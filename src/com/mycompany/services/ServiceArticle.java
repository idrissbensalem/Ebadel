/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.mycompany.entities.Article;
import com.mycompany.entities.Marque;
import com.mycompany.statics.statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

/**
 *
 * @author allela
 */
public class ServiceArticle {
    
    public boolean resultOK = true;

    public static ServiceArticle instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceArticle getInstance() {
        if (instance == null) {
            instance = new ServiceArticle();
        }
        return instance;
    }

    public ServiceArticle() {
        req = new ConnectionRequest();
    }

    public void ajouterArticle(Article art) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addarticle?user="+art.getUser()+"&categorie="+art.getCategorie()+"&marque="+art.getMarque()+"&souscategorie="+
                art.getSous_categorie()+"&nom="+art.getNom()+"&etat="+art.getEtat()+"&desc="+art.getDesc();
        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Article> affichageArticle() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Article> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displayarticle";
        req1.setUrl(url);

        req1.addResponseListener(new ActionListener<NetworkEvent>() {

            @Override
            public void actionPerformed(NetworkEvent evt) {

                try {
                    JSONParser jsonp;
                    jsonp = new JSONParser();
                    Map<String, Object> mapCategorie = jsonp.parseJSON(new CharArrayReader(new String(req1.getResponseData()).toCharArray()));
                    List<Map<String, Object>> listOfMaps = (List<Map<String, Object>>) mapCategorie.get("root");

                    for (Map<String, Object> obj : listOfMaps) {
                        Article a = new Article();

                        float id = Float.parseFloat(obj.get("idArticle").toString());
                        String nom = obj.get("nomArticle").toString();
                        String desc = obj.get("description").toString();
                        String etat = obj.get("etat").toString();
                        
                        LinkedHashMap<String, Object> sc = (LinkedHashMap<String, Object>) obj.get("sousCategorie");
                        String souscat = sc.get("nomSC").toString();
                        LinkedHashMap<String, Object> user = (LinkedHashMap<String, Object>) obj.get("user");
                        int iduser = Integer.parseInt(user.get("id").toString());
                        LinkedHashMap<String, Object> categorie = (LinkedHashMap<String, Object>) obj.get("categorie");
                        String idcategorie = categorie.get("nomC").toString();
                        LinkedHashMap<String, Object> mar = (LinkedHashMap<String, Object>) obj.get("marque");
                        String marque = mar.get("nomM").toString();
                        

                        a.setId((int) id);
                        a.setNom(nom);
                        a.setDesc(desc);
                        a.setEtat(etat);
                        a.setMarque(marque);
                        a.setSous_categorie(souscat);
                        a.setCategorie(idcategorie);
                        a.setUser(iduser);
                        result.add(a);
                    }
                } catch (IOException ex) {
                    ex.printStackTrace();
                }

            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req1);
        return result;
    }
    public Article getArticle(int id){
        
        ArrayList<Article> result = new ArrayList<>();
        Article cc = new Article();
        result = affichageArticle();
        
        for(Article c : result){
            if (c.getId()==id){
                cc = c;
            }
        }
        return cc;
        
    }

    public boolean deleteArticle(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deletearticle?id=" + id;

        req1.setUrl(url);

        req1.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {

                req1.removeResponseCodeListener(this);
            }
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);
        return resultOK;

    }
    
    public ArrayList<Marque> getMarques() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Marque> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displaymarque";
        req1.setUrl(url);

        req1.addResponseListener(new ActionListener<NetworkEvent>() {

            @Override
            public void actionPerformed(NetworkEvent evt) {

                try {
                    JSONParser jsonp;
                    jsonp = new JSONParser();
                    Map<String, Object> mapCategorie = jsonp.parseJSON(new CharArrayReader(new String(req1.getResponseData()).toCharArray()));
                    List<Map<String, Object>> listOfMaps = (List<Map<String, Object>>) mapCategorie.get("root");

                    for (Map<String, Object> obj : listOfMaps) {
                        Marque a = new Marque();

                        float id = Float.parseFloat(obj.get("id").toString());
                        String nom = obj.get("nomM").toString();
                        LinkedHashMap<String, Object> scat = (LinkedHashMap<String, Object>) obj.get("souscategorie");
                        float idscat = Float.parseFloat(scat.get("id").toString());
                        LinkedHashMap<String, Object> categorie = (LinkedHashMap<String, Object>) obj.get("categorie");
                        float idcategorie = Float.parseFloat(categorie.get("id").toString());
                        
                        a.setId((int) id);
                        a.setNom(nom);
                        a.setScat((int)idscat);
                        a.setCat((int)idcategorie);
                        result.add(a);
                    }
                } catch (IOException ex) {
                    ex.printStackTrace();
                }

            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req1);
        return result;
    }
    
    public Boolean editArticle(Article art) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/editarticle?id="+art.getId()+"user="+art.getUser()+"&categorie="+art.getCategorie()+"&marque="+art.getMarque()+"&souscategorie="+
                art.getSous_categorie()+"&nom="+art.getNom()+"&etat="+art.getEtat()+"&desc="+art.getDesc();
        req1.setUrl(url);
        req1.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK=req1.getResponseCode()==200;
                req1.removeResponseListener(this);//To change body of generated methods, choose Tools | Templates.
            }
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);
        return resultOK;
    }
}
