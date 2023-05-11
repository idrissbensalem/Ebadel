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
public class Offre {
    private int id;
    private int user;
    private int article;
    private String p_propose;
    private String per_utl;
    private String etat;
    private String desc;
    private String image;
    private float bonus;
    private String tel;

    public Offre() {
    }

    public Offre(int user, int article, String p_propose, String per_utl, String etat, String desc, String image, float bonus, String tel) {
        this.user = user;
        this.article = article;
        this.p_propose = p_propose;
        this.per_utl = per_utl;
        this.etat = etat;
        this.desc = desc;
        this.image = image;
        this.bonus = bonus;
        this.tel = tel;
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

    public int getProduit() {
        return article;
    }

    public void setProduit(int article) {
        this.article = article;
    }

    public String getP_propose() {
        return p_propose;
    }

    public void setP_propose(String p_propose) {
        this.p_propose = p_propose;
    }

    public String getPer_utl() {
        return per_utl;
    }

    public void setPer_utl(String per_utl) {
        this.per_utl = per_utl;
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

    public float getBonus() {
        return bonus;
    }

    public void setBonus(float bonus) {
        this.bonus = bonus;
    }

    public String getTel() {
        return tel;
    }

    public void setTel(String tel) {
        this.tel = tel;
    }
    
    
}
