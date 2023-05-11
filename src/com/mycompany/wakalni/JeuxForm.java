/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.wakalni;

import com.codename1.ui.Button;
import static com.codename1.ui.Component.LEFT;
import static com.codename1.ui.Component.RIGHT;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.Jeux;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceJeux;
import com.mycompany.services.ServiceUser;
import java.util.ArrayList;

/**
 *
 * @author ahmed
 */
public class JeuxForm extends SideMenuBaseForm {

    public JeuxForm(Resources res) {

        super(BoxLayout.y());
        setUIID("Toolbar");
        User u = new User();
        u = ServiceUser.getInstance().getCurrent(SessionManager.getId());
        Toolbar tb = getToolbar();
        tb.setTitleCentered(false);
        Image profilePic = res.getImage("01.jpg");
        Image mask = res.getImage("round-mask.png");
        profilePic = profilePic.fill(mask.getWidth(), mask.getHeight());
        Label profilePicLabel = new Label(profilePic, "ProfilePicTitle");
        profilePicLabel.setMask(mask.createMask());

        Button menuButton = new Button("");
        menuButton.setUIID("Title");
        FontImage.setMaterialIcon(menuButton, FontImage.MATERIAL_MENU);
        menuButton.addActionListener(e -> getToolbar().openSideMenu());

        Container titleCmp = BoxLayout.encloseY(
                FlowLayout.encloseIn(menuButton),
                BorderLayout.centerAbsolute(
                        BoxLayout.encloseY(
                                new Label(u.getFirstname(), "Title"),
                                new Label(u.getEmail(), "SubTitle")
                        )
                ).add(BorderLayout.WEST, profilePicLabel)
        );

        tb.setTitleComponent(titleCmp);

        add(new Label("Articles", "TodayTitle"));
        ArrayList<Jeux> jeux = new ArrayList<>();
        jeux = ServiceJeux.getInstance().affichageJeux();

        for (Jeux j : jeux) {
            TextField type = new TextField(j.getType(), "Type", 20, TextField.USERNAME);
            TextField titre = new TextField(j.getTitre(), "Titre", 20, TextField.USERNAME);
            TextField image = new TextField(j.getImage(), "Image", 20, TextField.USERNAME);
            TextField datedebut = new TextField(j.getDate_debut(), "Date debut", 20, TextField.USERNAME);
            TextField datefin = new TextField(j.getDate_debut(), "Date fin", 20, TextField.USERNAME);
            TextField produit = new TextField(j.getType(), "Produit", 20, TextField.USERNAME);
            TextField prix = new TextField(j.getProduit(), "Prix", 20, TextField.USERNAME);
            type.setEnabled(false);
            titre.setEnabled(false);
            image.setEnabled(false);
            datedebut.setEnabled(false);
            datefin.setEnabled(false);
            produit.setEnabled(false);
            prix.setEnabled(false);
            Button delButton = new Button("Delete");
            delButton.addActionListener(e -> {
                if (Dialog.show("Warning", "The categorie will be permanently deleted, Are you sure ?", "Ok", "Cancel")) {
                    ServiceJeux.getInstance().deleteJeux(j.getId());
                    new JeuxForm(res).show();
                }
            });
            Button partButton = new Button("Participate");
            partButton.addActionListener(e -> {
                if (Dialog.show("Success", "You will participate to this game", "Ok", "Cancel")) {
                    ServiceJeux.getInstance().participate(j.getId());
                    new JeuxForm(res).show();
                }
            });
            System.out.print("id jeu :" + j.getId());
            ArrayList<User> a = ServiceJeux.getInstance().participant(j.getId());
            for(User us: a){
                us.toString();
            }
            Button gButton = new Button("Gagner");
            gButton.addActionListener(e -> {
                int winner = ServiceJeux.getInstance().getWinner(a);
                ServiceJeux.getInstance().win(j.getId(), winner);
                if (Dialog.show("Congratulation", ServiceUser.getInstance().getCurrent(winner).getFirstname() + " " + 
                        ServiceUser.getInstance().getCurrent(winner).getLastname() + " is our winner", "Ok", "Cancel")) {
                    new JeuxForm(res).show();
                }
            });
            type.getAllStyles().setMargin(LEFT, 0);
            titre.getAllStyles().setMargin(LEFT, 0);
            image.getAllStyles().setMargin(LEFT, 0);
            datedebut.getAllStyles().setMargin(LEFT, 0);
            datefin.getAllStyles().setMargin(LEFT, 0);
            produit.getAllStyles().setMargin(LEFT, 0);
            prix.getAllStyles().setMargin(LEFT, 0);
            Label typeIcon = new Label("", "TextField");
            Label titreIcon = new Label("", "TextField");
            Label imageIcon = new Label("", "TextField");
            Label datedIcon = new Label("", "TextField");
            Label datefIcon = new Label("", "TextField");
            Label produitIcon = new Label("", "TextField");
            Label prixIcon = new Label("", "TextField");
            typeIcon.getAllStyles().setMargin(RIGHT, 0);
            titreIcon.getAllStyles().setMargin(RIGHT, 0);
            imageIcon.getAllStyles().setMargin(RIGHT, 0);
            datedIcon.getAllStyles().setMargin(RIGHT, 0);
            datefIcon.getAllStyles().setMargin(RIGHT, 0);
            produitIcon.getAllStyles().setMargin(RIGHT, 0);
            prixIcon.getAllStyles().setMargin(RIGHT, 0);
            FontImage.setMaterialIcon(typeIcon, FontImage.MATERIAL_CATEGORY, 3);
            FontImage.setMaterialIcon(titreIcon, FontImage.MATERIAL_CATEGORY, 3);
            FontImage.setMaterialIcon(imageIcon, FontImage.MATERIAL_CATEGORY, 3);
            FontImage.setMaterialIcon(datedIcon, FontImage.MATERIAL_SHOP, 3);
            FontImage.setMaterialIcon(datefIcon, FontImage.MATERIAL_DESCRIPTION, 3);
            FontImage.setMaterialIcon(produitIcon, FontImage.MATERIAL_STAR, 3);
            FontImage.setMaterialIcon(prixIcon, FontImage.MATERIAL_STAR, 3);
            Container by = BoxLayout.encloseY(
                    BorderLayout.center(type).
                            add(BorderLayout.WEST, typeIcon),
                    BorderLayout.center(titre).
                            add(BorderLayout.WEST, titreIcon),
                    BorderLayout.center(image).
                            add(BorderLayout.WEST, imageIcon),
                    BorderLayout.center(datedebut).
                            add(BorderLayout.WEST, datedIcon),
                    BorderLayout.center(datefin).
                            add(BorderLayout.WEST, datefIcon),
                    BorderLayout.center(produit).
                            add(BorderLayout.WEST, produitIcon),
                    BorderLayout.center(prix).
                            add(BorderLayout.WEST, prixIcon),
                    BoxLayout.encloseX(delButton, partButton, gButton)
            );
            add(by);
        }

        setupSideMenu(res);
    }

}
