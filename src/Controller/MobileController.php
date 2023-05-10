<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Boutique;
use App\Entity\Categorie;
use App\Entity\Review;
use App\Entity\Reclamation;
use App\Entity\Livraison;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Jeux;
use App\Entity\Marque;
use App\Entity\Offre;
use App\Entity\Souscategorie;
use App\Entity\User;
use App\Entity\Participation;
use Doctrine\DBAL\SQL\Parser\Exception;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Constraints\DateTime;



class MobileController extends AbstractController
{
    /**
     * @Route("mobile/signup", name="mobile_signup")
     */

    public function signupAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $firstname = $request->query->get("nom");
        $lastname = $request->query->get("prenom");
        $age = $request->query->get("age");
        $phonenumber = $request->query->get("telephone");
        $image = $request->query->get("image");
        $adresse = $request->query->get("adresse");
        $gender = $request->query->get("gender");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Response("email invalide");
        }
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setnom($firstname);
        $user->setPrenom($lastname);
        $user->setAge($age);
        $user->setTelephone($phonenumber);
        $user->setImage($image);
        $user->setAdresse($adresse);
        $user->setGender($gender);
        $user->setRoles(['ROLE_USER']);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("account created", 200);
        } catch (Exception $ex) {
            return new Response("exception" . $ex->getMessage());
        }
    }

    /**
     * @Route("mobile/login", name="mobile_login")
     */
    public function loginAction(Request $request)
    {
        $email = $request->query->get("email");
        $password = $request->query->get("password");

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            if ($password == $user->getPassword()) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'email', 'nom', 'prenom', 'telephone', 'adresse', 'gender', 'age', 'password', 'image']]);
                return new JsonResponse($formatted);
            } else {
                return new Response("password not found");
            }
        } else {
            return new Response("user not found");
        }
    }

    /**
     * @Route("mobile/cuser", name="mobile_cuser")
     */
    public function getCurrentUser(Request $request)
    {
        $id = $request->query->get("id");
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user) {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($user, null, [AbstractNormalizer::ATTRIBUTES => ['email', 'nom', 'prenom', 'telephone', 'adresse', 'gender', 'age', 'password', 'image','roles']]);
            return new JsonResponse($formatted);
        } else {
            return new Response("user");
        }
    }

    /**
     * @Route("mobile/edit/{id}", name="mobile_edit")
     */
    Public function editUserAction($id, Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $firstname = $request->query->get("firstname");
        $lastname = $request->query->get("lastname");
        $age = $request->query->get("age");
        $phonenumber = $request->query->get("telephone");
        $adresse = $request->query->get("addresse");
        $gender = $request->query->get("gender");

        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return new Response("email invalide");
        }
        $user->setEmail($email);
        $user->setnom($firstname);
        $user->setPrenom($lastname);
        $user->setAge($age);
        $user->setTelephone($phonenumber);
        $user->setAdresse($adresse);
        $user->setGender($gender);

        try {
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success", 200);
        }
        catch(Exception $ex){
            return new Response("failed".$ex->getMessage());
        }
    }
    /**
     * @Route("mobile/deactivate", name="mobile_deavtivate")
     */
    Public function desactivateUser(Request $request){
        $id = $request->query->get("id");
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if($user!=null ) {
            $em->remove($user);
            $em->flush();
            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("user deleted.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id user invalide.");
    }
    /**
     * @Route("mobile/editpassword", name="mobile_editpassword")
     */
    Public function editPasswordAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $id = $request->query->get("id");
        $password = $request->query->get("password");
        $em=$this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setPassword($password);
        try {
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success", 200);
        }
        catch(Exception $ex){
            return new Response("failed".$ex->getMessage());
        }
    }

    /******************Ajouter Reclamation*****************************************/
    /**
     * @Route("/mobile/addreclamation", name="add_reclamation")
     * @Method("POST")
     */

    public function ajouterReclamationAction(Request $request)
    {
        $reclamation = new Reclamation();
        $em = $this->getDoctrine()->getManager();
        $type = $request->query->get("type");
        $Destinataire = $request->query->get("destinataire");
        $Description = $request->query->get("description");
        $user = $em->getRepository(User::class)->find($request->query->get("user"));

        $reclamation->setType($type);
        $reclamation->setDestinataire($Destinataire);
        $reclamation->setDescription($Description);
        $reclamation->setUser($user);

        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation, null, [AbstractNormalizer::ATTRIBUTES => ["id", "type", "destinataire", "description", "user" => ["email"]]]);
        return new JsonResponse($formatted);
    }

    /******************affichage Reclamation*****************************************/

    /**
     * @Route("/mobile/displayreclamation", name="display_reclamation")
     */
    public function allReclamationAction()
    {

        $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'type', 'description', 'destinataire', 'user' => ['id']]]);

        return new JsonResponse($formatted);
    }

    /******************Supprimer Reclamtion*****************************************/

    /**
     * @Route("/mobile/deletereclamation", name="delete_reclamation")
     * @Method("DELETE")
     */

    public function deleteReclamationAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        if ($reclamation != null) {
            $em->remove($reclamation);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Reclamation a ete supprimee avec success.");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("id Reclamation invalide.");
    }
    /******************Ajouter Categories*****************************************/
    /**
     * @Route("/mobile/addcategorie", name="add_categories")
     * @Method("POST")
     */

    public function ajouterCategorieAction(Request $request)
    {
        $categorie = new Categorie();
        $em = $this->getDoctrine()->getManager();
        $nom = $request->query->get("nom");

        $categorie->setNomC($nom);

        $em->persist($categorie);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("categorie added succefully");
        return new JsonResponse($formatted);
    }

    /******************affichage Categories*****************************************/

    /**
     * @Route("/mobile/displaycategorie", name="display_categories")
     */
    public function allCategorieAction()
    {

        $categories = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categories, null, [AbstractNormalizer::ATTRIBUTES =>
        ['id', 'nomC']]);

        return new JsonResponse($formatted);
    }

    /******************Supprimer Categorie*****************************************/

    /**
     * @Route("/mobile/deletecategorie", name="delete_categorie")
     * @Method("DELETE")
     */

    public function deleteCategorieAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Categorie::class)->find($id);
        if ($categories != null) {
            $em->remove($categories);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Categorie a ete supprimee avec success.");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("id Categorie invalide.");
    }

    /******************Ajouter Article*****************************************/
    /**
     * @Route("/mobile/addarticle", name="add_article")
     * @Method("POST")
     */

    public function ajouterArticleAction(Request $request)
    {
        $article = new Article();
        $em = $this->getDoctrine()->getManager();
        $nom = $request->query->get("nom");
        $etat = $request->query->get("etat");
        $desc = $request->query->get("desc");
        $marque = $em->getRepository(Marque::class)->find($request->query->get("marque"));
        $souscat = $em->getRepository(Souscategorie::class)->find($request->query->get("souscategorie"));
        $cat = $em->getRepository(Categorie::class)->find($request->query->get("categorie"));
        $user = $em->getRepository(User::class)->find($request->query->get("user"));

        $article->setUser($user);
        $article->setNomArticle($nom);
        $article->setEtat($etat);
        $article->setDescription($desc);
        $article->setMarque($marque);
        $article->setSousCategorie($souscat);
        $article->setCategorie($cat);
        $article->setPeriodeUtilisation("90");

        $em->persist($article);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("article added succefully");
        return new JsonResponse($formatted);
    }

    /******************affichage articles*****************************************/

    /**
     * @Route("/mobile/displayarticle", name="display_article")
     */
    public function allArticleAction()
    {

        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($article, null, [AbstractNormalizer::ATTRIBUTES =>
        ['idArticle', 'nomArticle', 'description', 'etat', 'user' => ['id', 'email'], 'marque' => ['id', 'nomM'], 'sousCategorie' => ['id', 'nomSC'], 'categorie' => ['id', 'nomC']]]);

        return new JsonResponse($formatted);
    }

    /******************Supprimer article*****************************************/

    /**
     * @Route("/mobile/deletearticle", name="delete_article")
     * @Method("DELETE")
     */

    public function deleteArticleAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->find($id);
        if ($articles != null) {
            $em->remove($articles);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Article a ete supprimee avec success.");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("id Irticle invalide.");
    }


    /******************Ajouter Jeux*****************************************/
    /**
     * @Route("/mobile/addjeu", name="add_jeu")
     * @Method("POST")
     */

    public function ajouterJeuAction(Request $request)
    {
        $jeu = new Jeux();
        $em = $this->getDoctrine()->getManager();
        $type = $request->query->get("type");
        $titre = $request->query->get("titre");
        $image = $request->query->get("image");
        $dated = $request->query->get("datedebut");
        $datef = $request->query->get("datefin");
        $produit = $request->query->get("produit");
        $prix = $request->query->get("prix");
        $datedebut = date_create_from_format("Y-m-d", $dated);
        $datefin = date_create_from_format("Y-m-d", $datef);

        $jeu->setType($type);
        $jeu->setTitre($titre);
        $jeu->setImage($image);
        $jeu->setDateDebut($datedebut);
        $jeu->setDateFin($datefin);
        $jeu->setProduit($produit);
        $jeu->setPrix($prix);

        $em->persist($jeu);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("jeu added succefully");
        return new JsonResponse($formatted);
    }

    /******************affichage jeux*****************************************/

    /**
     * @Route("/mobile/displayjeux", name="display_jeu")
     */
    public function allJeuAction()
    {

        $jeux = $this->getDoctrine()->getManager()->getRepository(Jeux::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($jeux, null, [AbstractNormalizer::ATTRIBUTES =>
        ['id', 'type', 'titre', 'image', 'dateDebut' => ['timestamp'], 'dateFin' => ['timestamp'], 'produit', 'prix']]);

        return new JsonResponse($formatted);
    }

    /******************Supprimer Jeux*****************************************/

    /**
     * @Route("/mobile/deletejeu", name="delete_jeu")
     * @Method("DELETE")
     */

    public function deleteJeuAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->find($id);
        if ($articles != null) {
            $em->remove($articles);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Jeu a ete supprimee avec success.");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("id Jeu invalide.");
    }
    /******************Participer Jeux*****************************************/
    /**
     * @Route("/mobile/participate", name="participate_jeu")
     * @Method("POST")
     */

    public function participateJeuAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($request->query->get("userid"));
        $jeux = $em->getRepository(Jeux::class)->find($request->query->get("jeuid"));
        $participation = new Participation();
        $participation->setUser($user);
        $participation->setJeux($jeux);
        $em->persist($participation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("participation added succefully");
        return new JsonResponse($formatted);
    }

    /******************get participant*****************************************/

    /**
     * @Route("/mobile/getparticipant", name="get_participant")
     */
    public function getParticipantAction(Request $request)
    {

        $jeux = $this->getDoctrine()->getManager()->getRepository(Jeux::class)->find($request->query->get("id"));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($jeux, null, [AbstractNormalizer::ATTRIBUTES => ["participations" => ["id", "user" => ["id"]]]]);

        return new JsonResponse($formatted);
    }

    /******************get participant*****************************************/

    /**
     * @Route("/mobile/gagner", name="gagner")
     */
    public function gagnerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $jeux = $em->getRepository(Jeux::class)->find($request->query->get("idj"));
        $user = $em->getRepository(User::class)->find($request->query->get("idu"));
        $user->addJeuxGagnee($jeux);
        $jeux->setGagnant($user);
        $em->getRepository(Jeux::class)->save($jeux, false);
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("Winner picked !");

        return new JsonResponse($formatted);
    }

    /******************Ajouter boutique*****************************************/
    /**
     * @Route("/mobile/addboutique", name="add_boutique")
     * @Method("POST")
     */

    public function ajouterBoutiqueAction(Request $request)
    {
        $boutique = new Boutique();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($request->query->get("user"));
        $image = $request->query->get("image");
        $desc = $request->query->get("desc");
        $telp = $request->query->get("telp");
        $telf = $request->query->get("telf");
        $lien = $request->query->get("lien");
        $gouv = $request->query->get("gouv");
        $ville = $request->query->get("ville");
        $nom = $request->query->get("nom");

        $boutique->setNom($nom);
        $boutique->setUser($user);
        $boutique->setImage($image);
        $boutique->setDescription($desc);
        $boutique->setNumTelephone($telp);
        $boutique->setNumFixe($telf);
        $boutique->setLien($lien);
        $boutique->setGouvernorat($gouv);
        $boutique->setVille($ville);

        $em->persist($boutique);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("Boutique added succefully");
        return new JsonResponse($formatted);
    }

    /******************affichage boutique*****************************************/

    /**
     * @Route("/mobile/displayboutique", name="display_boutique")
     */
    public function allBoutiqueAction()
    {

        $boutique = $this->getDoctrine()->getManager()->getRepository(Boutique::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($boutique, null, [AbstractNormalizer::ATTRIBUTES =>
        ['id', 'image', 'lien', 'nom', 'description', 'user' => ['id'], 'numTelephone', 'numFixe', 'gouvernorat', 'ville']]);

        return new JsonResponse($formatted);
    }

    /******************Supprimer boutique*****************************************/

    /**
     * @Route("/mobile/deleteboutique", name="delete_boutique")
     * @Method("DELETE")
     */

    public function deleteBoutiqueAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->find($id);
        if ($articles != null) {
            $em->remove($articles);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Boutique a ete supprimee avec success.");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("id Boutique invalide.");
    }

    /******************Ajouter produit*****************************************/
    /**
     * @Route("/mobile/addproduit", name="add_produit")
     * @Method("POST")
     */

    public function ajouterProduitAction(Request $request)
    {
        $produit = new Produit();
        $em = $this->getDoctrine()->getManager();
        $boutique = $em->getRepository(Boutique::class)->find($request->query->get("boutique"));
        $titre = $request->query->get("titre");
        $prix = $request->query->get("prix");
        $image = $request->query->get("image");

        $produit->setBoutique($boutique);
        $produit->setTitre($titre);
        $produit->setPrix($prix);
        $produit->setImage($image);

        $em->persist($produit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("Produit added succefully");
        return new JsonResponse($formatted);
    }

    /******************affichage Produit*****************************************/

    /**
     * @Route("/mobile/displayproduit", name="display_produit")
     */
    public function allProduitAction()
    {

        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit, null, [AbstractNormalizer::ATTRIBUTES =>
        ['id', 'titre', 'prix', 'image', 'boutique' => ['id', 'nom']]]);

        return new JsonResponse($formatted);
    }

    /******************Supprimer produit*****************************************/

    /**
     * @Route("/mobile/deleteproduit", name="delete_produit")
     * @Method("DELETE")
     */

    public function deleteProduitAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);
        if ($produit != null) {
            $em->remove($produit);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("produit a ete supprimee avec success.");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("id produit invalide.");
    }

    /******************Ajouter Offre*****************************************/
    /**
     * @Route("/mobile/addoffre", name="add_offre")
     * @Method("POST")
     */

    public function ajouterOffreAction(Request $request)
    {
        $offre = new Offre();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($request->query->get("user"));
        $article = $em->getRepository(Produit::class)->find($request->query->get("article"));
        $pp = $request->query->get("pp");
        $pu = $request->query->get("pu");
        $etat = $request->query->get("etat");
        $desc = $request->query->get("desc");
        $image = $request->query->get("image");
        $bonus = $request->query->get("bonus");
        $tel = $request->query->get("tel");


        $offre->setUser($user);
        $offre->setArticle($article);
        $offre->setProduitPropose($pp);
        $offre->setPeriodeUtilisation($pu);
        $offre->setEtatProduitPropose($etat);
        $offre->setDescription($desc);
        $offre->setImage($image);
        $offre->setBonus($bonus);
        $offre->setNumTel($tel);

        $em->persist($offre);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("offre added succefully");
        return new JsonResponse($formatted);
    }

    /******************affichage Offre*****************************************/

    /**
     * @Route("/mobile/displayoffre", name="display_offre")
     */
    public function allOffreAction()
    {

        $offre = $this->getDoctrine()->getManager()->getRepository(Offre::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($offre, null, [AbstractNormalizer::ATTRIBUTES =>
        ['idOffre', 'title', 'produitPropose', 'periodeUtilisation', 'etatProduitPropose', 'description', 'bonus', 'image', 'numTel', 'user' => ['id', 'email'], 'article' => ['idArticle']]]);

        return new JsonResponse($formatted);
    }

    /******************Supprimer offre*****************************************/

    /**
     * @Route("/mobile/deleteoffre", name="delete_offre")
     * @Method("DELETE")
     */

    public function deleteOffreAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
        if ($offre != null) {
            $em->remove($offre);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("offre a ete supprimee avec success.");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("id offre invalide.");
    }

    /******************Ajouter Review*****************************************/
    /**
     * @Route("/mobile/addreview", name="add_review")
     * @Method("POST")
     */

    public function ajouterReviewAction(Request $request)
    {
        $review = new Review();
        $em = $this->getDoctrine()->getManager();
        $comment = $request->query->get("comment");
        $article = $em->getRepository(Article::class)->find($request->query->get("article"));

        $review->setComment($comment);
        $review->setArticle($article);
        $review->setRate(1);

        $em->persist($review);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($review, null, [AbstractNormalizer::ATTRIBUTES => ["id", "comment", "article" => ["idArticle"]]]);
        return new JsonResponse($formatted);
    }

    /******************affichage Review*****************************************/

    /**
     * @Route("/mobile/displayreview", name="display_review")
     */
    public function allReviewAction()
    {

        $review = $this->getDoctrine()->getManager()->getRepository(Review::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($review, null, [AbstractNormalizer::ATTRIBUTES => ["id", "rate", "comment", "article" => ["idArticle"]]]);

        return new JsonResponse($formatted);
    }

    /******************Ajouter Marque*****************************************/
    /**
     * @Route("/mobile/addmarque", name="add_marque")
     * @Method("POST")
     */

     public function ajouterMarqueAction(Request $request)
     {
         $marque = new Marque();
         $em = $this->getDoctrine()->getManager();
         $nom = $request->query->get("nom");
         $cat = $em->getRepository(Categorie::class)->find($request->query->get("cat"));
         $scat = $em->getRepository(Souscategorie::class)->find($request->query->get("sc"));
 
         $marque->setNom($nom);
         $marque->setCategorie($cat);
         $marque->setSouscategorie($scat);
 
         $em->persist($marque);
         $em->flush();
         $serializer = new Serializer([new ObjectNormalizer()]);
         $formatted = $serializer->normalize($marque, null, [AbstractNormalizer::ATTRIBUTES => ["id", 'sousCategorie' => ['id', 'nomSC'], 'categorie' => ['id', 'nomC']]]);
         return new JsonResponse($formatted);
     }
 
     
    /******************affichage marque*****************************************/

    /**
     * @Route("/mobile/displaymarque", name="display_marque")
     */
    public function allMarquesAction()
    {
        $scat = $this->getDoctrine()->getManager()->getRepository(Marque::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($scat, null, [AbstractNormalizer::ATTRIBUTES =>
        ['id', 'nomM', 'categorie' => ['id', 'nomC'], 'souscategorie' => ['id', 'nom']]]);

        return new JsonResponse($formatted);
    }
    /******************Supprimer marque*****************************************/

    /**
     * @Route("/mobile/deletemarque", name="delete_marque")
     * @Method("DELETE")
     */

     public function deleteMarqueAction(Request $request)
     {
         $id = $request->get("id");
 
         $em = $this->getDoctrine()->getManager();
         $offre = $em->getRepository(Offre::class)->find($id);
         if ($offre != null) {
             $em->remove($offre);
             $em->flush();
 
             $serialize = new Serializer([new ObjectNormalizer()]);
             $formatted = $serialize->normalize("marque a ete supprimee avec success.");
             return new JsonResponse($formatted);
         }
         return new JsonResponse("id marque invalide.");
     }
}
