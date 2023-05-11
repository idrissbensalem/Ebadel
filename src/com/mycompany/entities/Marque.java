/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.entities;

/**
 *
 * @author amine
 */
public class Marque {
    private int id;
    private String nom;
    private int scat;
    private int cat;

    public Marque(String nom, int scat, int cat) {
        this.nom = nom;
        this.scat = scat;
        this.cat = cat;
    }

    public Marque() {
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public int getScat() {
        return scat;
    }

    public void setScat(int scat) {
        this.scat = scat;
    }

    public int getCat() {
        return cat;
    }

    public void setCat(int cat) {
        this.cat = cat;
    }
    
    
    
}
