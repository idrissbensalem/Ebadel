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
import com.mycompany.entities.Boutique;
import com.mycompany.entities.Marque;
import com.mycompany.statics.statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

/**
 *
 * @author idriss
 */
public class ServiceBoutique {
     public boolean resultOK = true;

    public static ServiceBoutique instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceBoutique getInstance() {
        if (instance == null) {
            instance = new ServiceBoutique();
        }
        return instance;
    }

    public ServiceBoutique() {
        req = new ConnectionRequest();
    }

    public void ajouterBoutique(Boutique b) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addboutique?user="+b.getUser()+"&nom="+b.getNom()+"&image="+b.getImage()+"&lien="+b.getLien()+"&desc="+b.getDesc()+"&telp="+
                b.getTelp()+"&telf="+b.getTelf()+"&gouv="+b.getGouv()+"&ville="+b.getVille();
        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Boutique> affichageBoutique() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Boutique> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displayboutique";
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
                        Boutique a = new Boutique();

                        float id = Float.parseFloat(obj.get("id").toString());
                        String nom = obj.get("nom").toString();
                        String image = obj.get("image").toString();
                        String desc = obj.get("description").toString();
                        String lien = obj.get("lien").toString();
                        String telp  = obj.get("numTelephone").toString();
                        String telf = obj.get("numFixe").toString();
                        String gouv = obj.get("gouvernorat").toString();
                        String ville = obj.get("ville").toString();
                        LinkedHashMap<String, Object> user = (LinkedHashMap<String, Object>) obj.get("user");
                        float iduser = Float.parseFloat(user.get("id").toString());
                        

                        a.setId((int) id);
                        a.setNom(nom);
                        a.setImage(image);
                        a.setUser((int)iduser);
                        a.setDesc(desc);
                        a.setLien(lien);
                        a.setGouv(gouv);
                        a.setVille(ville);
                        a.setTelf(telf);
                        a.setTelp(telp);
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

    public boolean deleteBoutique(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deleteboutique?id=" + id;

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
    
    public Boutique getBoutique(int id){
        
        ArrayList<Boutique> result = new ArrayList<>();
        Boutique cc = new Boutique();
        result = affichageBoutique();
        
        for(Boutique c : result){
            if (c.getId()==id){
                cc = c;
            }
        }
        return cc;
        
    }
    
    public Boolean editBoutique(Boutique b) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/editboutique?id="+b.getId()+"&user="+b.getUser()+"&nom="+b.getNom()+"&lien="+b.getLien()+"&desc="+b.getDesc()+"&telp="+
                b.getTelp()+"&telf="+b.getTelf()+"&gouv="+b.getGouv()+"&ville="+b.getVille();
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
