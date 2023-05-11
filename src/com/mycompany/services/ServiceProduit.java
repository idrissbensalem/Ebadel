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
import com.mycompany.entities.Produit;
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
public class ServiceProduit {
    public boolean resultOK = true;

    public static ServiceProduit instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceProduit getInstance() {
        if (instance == null) {
            instance = new ServiceProduit();
        }
        return instance;
    }

    public ServiceProduit() {
        req = new ConnectionRequest();
    }

    public void ajouterProduit(Produit b) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addproduit?boutique="+b.getBoutique()+"&titre="+b.getTitre()+"&image="+b.getImage()+"&prix="+b.getPrix();
        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Produit> affichageProduit() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Produit> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displayproduit";
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
                        Produit a = new Produit();

                        float id = Float.parseFloat(obj.get("id").toString());
                        String titre = obj.get("titre").toString();
                        String image = obj.get("image").toString();
                        Float prix = Float.parseFloat(obj.get("prix").toString());
                        LinkedHashMap<String, Object> mar = (LinkedHashMap<String, Object>) obj.get("boutique");
                        float idb = Float.parseFloat(mar.get("id").toString());
                        a.setId((int) id);
                        a.setBoutique((int)idb);
                        a.setTitre(titre);
                        a.setImage(image);
                        a.setPrix(prix);
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

    public boolean deleteProduit(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deleteproduit?id=" + id;

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
    
    public Produit getProduit(int id){
        
        ArrayList<Produit> result = new ArrayList<>();
        Produit cc = new Produit();
        result = affichageProduit();
        
        for(Produit c : result){
            if (c.getId()==id){
                cc = c;
            }
        }
        return cc;
        
    }
    
    public Boolean editProduit(Produit b) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/editreclamation?id="+b.getId()+"&boutique="+b.getBoutique()+"&titre="+b.getTitre()+"&image="+b.getImage()+"&prix="+b.getPrix();
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
