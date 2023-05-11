/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.entities;

/**
 *
 * @author ahmed
 */
public class Jeux {
    private int id;
    private String type;
    private String titre;
    private String image;
    private String date_debut;
    private String date_fin;
    private String produit;
    private float prix;
    private int gagnant;

    public Jeux(String type, String titre, String image, String date_debut, String date_fin, String produit, float prix) {
        this.type = type;
        this.titre = titre;
        this.image = image;
        this.date_debut = date_debut;
        this.date_fin = date_fin;
        this.produit = produit;
        this.prix = prix;
    }

    public Jeux() {
    }
    
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public String getDate_debut() {
        return date_debut;
    }

    public void setDate_debut(String date_debut) {
        this.date_debut = date_debut;
    }

    public String getDate_fin() {
        return date_fin;
    }

    public void setDate_fin(String date_fin) {
        this.date_fin = date_fin;
    }

    public String getProduit() {
        return produit;
    }

    public void setProduit(String produit) {
        this.produit = produit;
    }

    public float getPrix() {
        return prix;
    }

    public void setPrix(float prix) {
        this.prix = prix;
    }

    public int getGagnant() {
        return gagnant;
    }

    public void setGagnant(int gagant) {
        this.gagnant = gagant;
    }

    @Override
    public String toString() {
        return "Jeux{" + "id=" + id + ", type=" + type + ", titre=" + titre + ", image=" + image + ", date_debut=" + date_debut + ", date_fin=" + date_fin + ", produit=" + produit + ", prix=" + prix + ", gagnant=" + gagnant + '}';
    }
    
    
    
    
}
