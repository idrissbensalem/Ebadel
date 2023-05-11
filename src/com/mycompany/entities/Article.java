/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.entities;

/**
 *
 * @author allela
 */
public class Article {
    
    private int id;
    private String categorie;
    private String marque;
    private String sous_categorie;
    private int user;
    private String nom;
    private String etat;
    private String desc;
    private String image;

    public Article(String categorie, String marque, String sous_categorie, int user, String nom, String etat, String desc, String image) {
        this.categorie = categorie;
        this.marque = marque;
        this.sous_categorie = sous_categorie;
        this.user = user;
        this.nom = nom;
        this.etat = etat;
        this.desc = desc;
        this.image = image;
    }

    public Article(int user, String categorie, String marque, String sous_categorie, String nom, String etat, String desc) {
        this.user = user;
        this.categorie = categorie;
        this.marque = marque;
        this.sous_categorie = sous_categorie;
        this.nom = nom;
        this.etat = etat;
        this.desc = desc;
    }

    public Article(int id, String nom, String etat, String desc) {
        this.id=id;
        this.nom = nom;
        this.etat = etat;
        this.desc = desc;
    }

    public Article() {
    }
    
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getCategorie() {
        return categorie;
    }

    public void setCategorie(String categorie) {
        this.categorie = categorie;
    }

    public String getMarque() {
        return marque;
    }

    public void setMarque(String marque) {
        this.marque = marque;
    }

    public String getSous_categorie() {
        return sous_categorie;
    }

    public void setSous_categorie(String sous_categorie) {
        this.sous_categorie = sous_categorie;
    }

    public int getUser() {
        return user;
    }

    public void setUser(int user) {
        this.user = user;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getEtat() {
        return etat;
    }

    public void setEtat(String etat) {
        this.etat = etat;
    }

    public String getDesc() {
        return desc;
    }

    public void setDesc(String desc) {
        this.desc = desc;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }
    
       
    
}
