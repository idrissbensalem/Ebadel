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
public class Boutique {
    private int id;
    private int user;
    private String nom;
    private String image;
    private String lien;
    private String desc;
    private String telp;
    private String telf;
    private String gouv;
    private String ville;

    public Boutique(int user, String nom,String lien, String desc, String telp, String telf, String gouv, String ville) {
        this.user = user;
        this.nom = nom;
        this.lien = lien;
        this.desc = desc;
        this.telp = telp;
        this.telf = telf;
        this.gouv = gouv;
        this.ville = ville;
    }

    public Boutique(int id, int user, String nom, String lien, String desc, String telp, String telf, String gouv, String ville) {
        this.id = id;
        this.user = user;
        this.nom = nom;
        this.lien = lien;
        this.desc = desc;
        this.telp = telp;
        this.telf = telf;
        this.gouv = gouv;
        this.ville = ville;
    }

    public Boutique(int user,String nom, String image, String lien, String desc, String telp, String telf, String gouv, String ville) {
        this.user = user;
        this.nom = nom;
        this.image = image;
        this.lien = lien;
        this.desc = desc;
        this.telp = telp;
        this.telf = telf;
        this.gouv = gouv;
        this.ville = ville;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public Boutique() {
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getUser() {
        return user;
    }

    public void setUser(int user) {
        this.user = user;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public String getLien() {
        return lien;
    }

    public void setLien(String lien) {
        this.lien = lien;
    }

    public String getDesc() {
        return desc;
    }

    public void setDesc(String desc) {
        this.desc = desc;
    }

    public String getTelp() {
        return telp;
    }

    public void setTelp(String telp) {
        this.telp = telp;
    }

    public String getTelf() {
        return telf;
    }

    public void setTelf(String telf) {
        this.telf = telf;
    }

    public String getGouv() {
        return gouv;
    }

    public void setGouv(String gouv) {
        this.gouv = gouv;
    }

    public String getVille() {
        return ville;
    }

    public void setVille(String ville) {
        this.ville = ville;
    }
    
    
}
