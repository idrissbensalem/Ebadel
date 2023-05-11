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
import com.mycompany.entities.Offre;
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
public class ServiceOffre {
    public boolean resultOK = true;

    public static ServiceOffre instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceOffre getInstance() {
        if (instance == null) {
            instance = new ServiceOffre();
        }
        return instance;
    }

    public ServiceOffre() {
        req = new ConnectionRequest();
    }

    public void ajouterOffre(Offre b) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addoffre?user="+b.getUser()+"&article="+b.getProduit()+"&pp="+b.getP_propose()+"&pu="+b.getPer_utl()+
                "&etat="+b.getEtat()+"&desc="+b.getDesc()+"&image="+b.getImage()+"&bonus="+b.getBonus()+"&tel="+b.getTel();
        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Offre> affichageOffre() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Offre> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displayoffre";
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
                        Offre a = new Offre();

                        float id = Float.parseFloat(obj.get("id").toString());
                        LinkedHashMap<String, Object> user = (LinkedHashMap<String, Object>) obj.get("user");
                        float iduser = Float.parseFloat(user.get("id").toString());
                        LinkedHashMap<String, Object> pr = (LinkedHashMap<String, Object>) obj.get("produit");
                        float idpr = Float.parseFloat(user.get("id").toString());
                        String pp = obj.get("produitPropose").toString();
                        String pu = obj.get("periodeUtilisation").toString();
                        String etat = obj.get("etat").toString();
                        String desc = obj.get("description").toString();
                        String image  = obj.get("image").toString();
                        float bonus = Float.parseFloat(obj.get("bonus").toString());
                        String tel = obj.get("numTel").toString();
                        

                        a.setId((int) id);
                        a.setUser((int)iduser);
                        a.setProduit((int)idpr);
                        a.setP_propose(pp);
                        a.setPer_utl(pu);
                        a.setEtat(etat);
                        a.setDesc(desc);
                        a.setBonus(bonus);
                        a.setTel(tel);
                        a.setImage(image);
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

    public boolean deleteOffre(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deleteoffre?id=" + id;

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
    
    public Offre getOffre(int id){
        
        ArrayList<Offre> result = new ArrayList<>();
        Offre cc = new Offre();
        result = affichageOffre();
        
        for(Offre c : result){
            if (c.getId()==id){
                cc = c;
            }
        }
        return cc;
        
    }
}
