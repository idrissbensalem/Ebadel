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
import com.mycompany.entities.Categorie;
import com.mycompany.statics.statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author amine
 */
public class ServiceCategorie {

    public boolean resultOK = true;

    public static ServiceCategorie instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceCategorie getInstance() {
        if (instance == null) {
            instance = new ServiceCategorie();
        }
        return instance;
    }

    public ServiceCategorie() {
        req = new ConnectionRequest();
    }

    public void ajouterCategorie(Categorie cat) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addcategorie?nom=" + cat.getNom();

        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Categorie> affichageCategorie() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Categorie> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displaycategorie";
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
                        Categorie c = new Categorie();
                        float id = Float.parseFloat(obj.get("id").toString());
                        String nom = obj.get("nomC").toString();
                        c.setNom(nom);
                        c.setId((int) id);
                        result.add(c);
                    }
                } catch (IOException ex) {
                    ex.printStackTrace();
                }

            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req1);
        return result;
    }

    public Categorie getCategorie(int id) {

        ArrayList<Categorie> result = new ArrayList<>();
        Categorie cc = new Categorie();
        result = affichageCategorie();

        for (Categorie c : result) {
            if (c.getId() == id) {
                cc = c;
            }
        }
        return cc;

    }

    public boolean deleteCategorie(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deletecategorie?id=" + id;

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

    public Boolean editCategorie(Categorie b) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/editcategorie?id="+b.getId()+"&?nom=" + b.getNom();
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
