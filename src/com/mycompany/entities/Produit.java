    /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.entities;

/**
 *
 * @author idriss
 */
public class Produit {
    private int id;
    private int boutique;
    private String titre;
    private float prix;
    private String image;

    public Produit(int boutique, String titre, float prix, String image) {
        this.boutique = boutique;
        this.titre = titre;
        this.prix = prix;
        this.image = image;
    }

    public Produit(int id, int boutique, String titre, float prix) {
        this.id = id;
        this.boutique = boutique;
        this.titre = titre;
        this.prix = prix;
    }

    public Produit() {
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getBoutique() {
        return boutique;
    }

    public void setBoutique(int boutique) {
        this.boutique = boutique;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    public float getPrix() {
        return prix;
    }

    public void setPrix(float prix) {
        this.prix = prix;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }
    
    
    
}
