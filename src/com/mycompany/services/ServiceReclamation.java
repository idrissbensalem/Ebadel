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
import com.mycompany.entities.Reclamation;
import com.mycompany.statics.statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

/**
 *
 * @author messoudi
 */
public class ServiceReclamation {
    
    public boolean resultOK = true;

    public static ServiceReclamation instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceReclamation getInstance() {
        if (instance == null) {
            instance = new ServiceReclamation();
        }
        return instance;
    }

    public ServiceReclamation() {
        req = new ConnectionRequest();
    }

    public void ajouterReclamation(Reclamation rec) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addreclamation?type=" + rec.getType()+ "&destinataire=" + rec.getDestinataire()+ "&description=" + rec.getDescription()+ "&user=" + rec.getUser()+ "&id=0";

        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Reclamation> affichageReclamation() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Reclamation> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displayreclamation";
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
                        Reclamation c = new Reclamation();

                        float id = Float.parseFloat(obj.get("id").toString());
                        String type = obj.get("type").toString();
                        String destinataire = obj.get("destinataire").toString();
                        String description = obj.get("description").toString();
                        LinkedHashMap<String, Object> user = (LinkedHashMap<String, Object>) obj.get("user");
                        int iduser = Integer.parseInt(user.get("id").toString());

                        c.setId((int) id);
                        c.setType(type);
                        c.setDescription(description);
                        c.setDestinataire(destinataire);
                        c.setUser(iduser);
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

    public boolean deleteReclamation(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deletereclamation?id=" + id;

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
    
    public Reclamation getReclamation(int id){
        
        ArrayList<Reclamation> result = new ArrayList<>();
        Reclamation cc = new Reclamation();
        result = affichageReclamation();
        
        for(Reclamation c : result){
            if (c.getId()==id){
                cc = c;
            }
        }
        return cc;
        
    }
    
    public Boolean editReclamation(Reclamation rec) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/editreclamation?id="+rec.getId()+"&?type=" + rec.getType()+ "&destinataire=" + rec.getDestinataire()+ "&description=" + rec.getDescription()+ "&user=" + rec.getUser()+ "&id=0";
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
