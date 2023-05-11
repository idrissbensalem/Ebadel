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
import com.mycompany.entities.Review;
import com.mycompany.statics.statics;
import java.io.IOException;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

/**
 *
 * @author messaoudi
 */
public class ServiceReview {

    public boolean resultOK = true;

    public static ServiceReview instance = null;

    public static NetworkManager instances;

    private ConnectionRequest req;

    public static ServiceReview getInstance() {
        if (instance == null) {
            instance = new ServiceReview();
        }
        return instance;
    }

    public ServiceReview() {
        req = new ConnectionRequest();
    }

    public void ajouterReview(Review rec) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/addreview?comment=" + rec.getComments() + "&article=" + rec.getArticle();
        req1.setUrl(url);
        req1.addResponseListener((e) -> {
            String str = new String(req1.getResponseData());
            System.out.println("data = " + str);
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);

    }

    public ArrayList<Review> affichageReview() {

        ConnectionRequest req1 = new ConnectionRequest();
        ArrayList<Review> result = new ArrayList<>();
        String url = statics.BASE_URL + "/mobile/displayreview";
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
                        Review c = new Review();
                        float id = Float.parseFloat(obj.get("id").toString());
                        String comment = obj.get("comment").toString();
                        LinkedHashMap<String, Object> article = (LinkedHashMap<String, Object>) obj.get("article");
                        float idart = Float.parseFloat(article.get("idArticle").toString());
                        float rate = Float.parseFloat(obj.get("rate").toString());

                        c.setId((int) id);
                        c.setComments(comment);
                        c.setArticle((int) idart);
                        c.setRate((int)rate);
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

    public boolean deleteReview(int id) {

        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deletereview?id=" + id;

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

    public Review getReview(int id) {

        ArrayList<Review> result = new ArrayList<>();
        Review cc = new Review();
        result = affichageReview();

        for (Review c : result) {
            if (c.getId() == id) {
                cc = c;
            }
        }
        return cc;

    }

    public String getRating(int id) {
        ArrayList<Review> result = new ArrayList<>();
        Review cc = new Review();
        result = affichageReview();
        int i = 0;
        int x = 0;
        for (Review c : result) {
            if (c.getArticle() == id) {
                i = i + (int)c.getRate();
                x++;
            }
        }
        System.out.println("aa"+i);
        System.out.println("aa"+x);
        float d = (float)i/(float)x;
        System.out.println("aa"+d);
        DecimalFormat df = new DecimalFormat("#0.0");
        String fn = df.format(d);
        System.out.println("bb"+fn);

        return fn;
    }
}
