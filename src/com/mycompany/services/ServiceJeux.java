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
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.events.ActionListener;
import com.mycompany.entities.Jeux;
import com.mycompany.entities.User;
import com.mycompany.statics.statics;
import com.mycompany.wakalni.SessionManager;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;
import java.util.Random;

/**
 *
 * @author ahmed
 */
public class ServiceJeux {
    public boolean resultOK = true;

    public static ServiceJeux instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceJeux getInstance() {
        if (instance == null) {
            instance = new ServiceJeux();
        }
        return instance;
    }

    public ServiceJeux() {
        req = new ConnectionRequest();
    }

    public void ajouterJeux(Jeux j) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addjeu?type=" + j.getType()+"&titre="+j.getTitre()+"&image="+j.getImage()+"&datedebut="+j.getDate_debut()+"&datefin="+
                j.getDate_fin()+"&produit="+j.getProduit()+"&prix="+j.getPrix()+"&gagnant="+j.getGagnant();

        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Jeux> affichageJeux() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Jeux> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displayjeux";
        req1.setUrl(url);

        req1.addResponseListener(new ActionListener<NetworkEvent>() {

            @Override
            public void actionPerformed(NetworkEvent evt) {

                try {
                    JSONParser jsonp;
                    jsonp = new JSONParser();
                    Map<String, Object> mapJeux = jsonp.parseJSON(new CharArrayReader(new String(req1.getResponseData()).toCharArray()));
                    List<Map<String, Object>> listOfMaps = (List<Map<String, Object>>) mapJeux.get("root");

                    for (Map<String, Object> obj : listOfMaps) {
                        Jeux c = new Jeux();
                        SimpleDateFormat frm = new SimpleDateFormat("yyyy-MM-dd");
                        
                        float id = Float.parseFloat(obj.get("id").toString());
                        String type = obj.get("type").toString();
                        String titre = obj.get("titre").toString();
                        String image = obj.get("image").toString();
                        LinkedHashMap<String, Object> dd = (LinkedHashMap<String, Object>) obj.get("dateDebut");
                        String tsdatedebut = dd.get("timestamp").toString();
                        
                        Date currentTime = new Date(Double.valueOf(tsdatedebut).longValue() * 1000);
                        String datedebut = frm.format(currentTime);
                        
                        LinkedHashMap<String, Object> df = (LinkedHashMap<String, Object>) obj.get("dateFin");
                        String tsdatefin = df.get("timestamp").toString().trim();
                        
                        Date currentT = new Date(Double.valueOf(tsdatefin).longValue() * 1000);
                        String datefin = frm.format(currentTime);
                        
                        String produit = obj.get("produit").toString();
                        float prix = Float.parseFloat(obj.get("prix").toString());
                        
                        c.setType(type);
                        c.setId((int)id);
                        c.setTitre(titre);
                        c.setImage(image);
                        c.setDate_debut(datedebut);
                        c.setDate_fin(datefin);
                        c.setProduit(produit);
                        c.setPrix(prix);
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

    public boolean deleteJeux(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deletejeux?id=" + id;

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
    public Jeux getJeux(int id){
        
        ArrayList<Jeux> result = new ArrayList<>();
        Jeux cc = new Jeux();
        result = affichageJeux();
        
        for(Jeux c : result){
            if (c.getId()==id){
                cc = c;
            }
        }
        return cc;
        
    }
    
    public boolean participate (int id){
        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/participate?userid="+SessionManager.getId()+"&jeuid=" + id;

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
    public ArrayList<User> participant(int idj){
        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<User> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/getparticipant?id="+idj;
        req1.setUrl(url);
        req1.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                    JSONParser jsonp = new JSONParser();
                    Map<String,Object> mapJeux = jsonp.parseJSON(new CharArrayReader(new String(req1.getResponseData()).toCharArray()));
                    List<Map<String, Object>> listOfMaps = (List<Map<String, Object>>) mapJeux.get("participations");

                    for (Map<String, Object> obj : listOfMaps) {
                        Jeux c = new Jeux();
                        //LinkedHashMap<String, Object> dd = (LinkedHashMap<String, Object>) obj.get("participations");
                        LinkedHashMap<String, Object> df = (LinkedHashMap<String, Object>) obj.get("user");
                        float iduser = Float.parseFloat(df.get("id").toString());
                        System.out.print(iduser);
                        result.add(ServiceUser.getInstance().getCurrent((int)iduser));
                    }
                } catch (IOException ex) {
                    ex.printStackTrace();
                }

            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req1);
        return result;
    }
    
    public boolean win (int idu, int idj){
        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/gagner?idj="+idj+"&idu=" + idu;

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
    
    public int getWinner(ArrayList<User> items) {
        if (items.isEmpty()) {
            throw new IllegalArgumentException("The item list is empty.");
        }
        
        Random random = new Random();
        int randomIndex = random.nextInt(items.size());
        
        User randomItem = items.get(randomIndex);
        return randomItem.getID();
    }
    
}
