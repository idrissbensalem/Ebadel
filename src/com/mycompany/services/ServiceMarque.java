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
import com.mycompany.entities.Marque;
import com.mycompany.statics.statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

/**
 *
 * @author amine
 */
public class ServiceMarque {
    public boolean resultOK = true;

    public static ServiceMarque instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceMarque getInstance() {
        if (instance == null) {
            instance = new ServiceMarque();
        }
        return instance;
    }

    public ServiceMarque() {
        req = new ConnectionRequest();
    }

    public void ajouterMarque(Marque j) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addmarque?nom="+j.getNom()+"&cat="+j.getCat()+"&sc="+j.getScat();

        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Marque> affichageMarque() {

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
                    Map<String, Object> mapMarque = jsonp.parseJSON(new CharArrayReader(new String(req1.getResponseData()).toCharArray()));
                    List<Map<String, Object>> listOfMaps = (List<Map<String, Object>>) mapMarque.get("root");

                    for (Map<String, Object> obj : listOfMaps) {
                        Marque c = new Marque();
                        float id = Float.parseFloat(obj.get("id").toString());
                        String nom = obj.get("nom").toString();
                        LinkedHashMap<String, Object> dd = (LinkedHashMap<String, Object>) obj.get("categorie");
                        float idc = Float.parseFloat(dd.get("id").toString());
                        LinkedHashMap<String, Object> df = (LinkedHashMap<String, Object>) obj.get("sousCategorie");
                        float idsc = Float.parseFloat(df.get("id").toString());
                        
                        c.setNom(nom);
                        c.setId((int)id);
                        c.setCat((int)idc);
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

    public boolean deleteMarque(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deletemarque?id=" + id;

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
    
    public Marque getMarque(int id){
        
        ArrayList<Marque> result = new ArrayList<>();
        Marque cc = new Marque();
        result = affichageMarque();
        
        for(Marque c : result){
            if (c.getId()==id){
                cc = c;
            }
        }
        return cc;
        
    }
}
