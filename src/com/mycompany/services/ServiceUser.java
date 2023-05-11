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
import java.util.Properties;
import com.codename1.ui.Dialog;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.User;
import com.mycompany.statics.statics;
import com.mycompany.wakalni.ProfileForm;
import com.mycompany.wakalni.SessionManager;
import com.sun.mail.smtp.SMTPTransport;
import java.util.ArrayList;
import java.util.Date;
import java.util.Map;
import java.util.Random;
import javax.mail.Message;
import javax.mail.Session;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

/**
 *
 * @author houssem
 */
public class ServiceUser {

    public static ServiceUser instance = null;
    String json;
    public static boolean resultOK = true;

    private ConnectionRequest req;

    public static ServiceUser getInstance() {
        if (instance == null) {
            instance = new ServiceUser();
        }
        return instance;
    }

    public ServiceUser() {
        req = new ConnectionRequest();
    }

    public void signup(String email, String firstname, String lastname, String password, String cpassword, int age, int phonenumber, String adresse, String gender, Resources res) {

        if (!password.equals(cpassword)) {
            Dialog.show("erreur", "passwords not matching", "ok", null);
        }
        String url = statics.BASE_URL + "/mobile/signup?email=" + email + "&password=" + password + "&nom=" + firstname
                + "&prenom=" + lastname + "&age=" + age + "&telephone=" + phonenumber + "&gender=" + gender + "&adresse=" + adresse;
        req.setUrl(url);
        req.addResponseListener((e) -> {
            byte[] data = (byte[]) e.getMetaData();
            String responsedata = new String(data);
            System.out.print("data ====>" + responsedata);
        });

        NetworkManager.getInstance().addToQueueAndWait(req);
    }

    public void signin(String username, String password, Resources rs) {

        String url = statics.BASE_URL + "/mobile/login?email=" + username + "&password=" + password;
        req = new ConnectionRequest(url, false); //false ya3ni url mazlt matba3thtich lel server
        req.setUrl(url);

        req.addResponseListener((NetworkEvent e) -> {

            JSONParser j = new JSONParser();

            String json = new String(req.getResponseData()) + "";

            try {

                if (json.equals("password not found") || json.equals("user not found")) {
                    Dialog.show("Echec d'authentification", "Username ou mot de passe éronné", "OK", null);
                } else {
                    System.out.println("data ==" + json);

                    Map<String, Object> user = j.parseJSON(new CharArrayReader(json.toCharArray()));

                    //Session 
                    float id = Float.parseFloat(user.get("id").toString());
                    SessionManager.setId((int) id);//jibt id ta3 user ly3ml login w sajltha fi session ta3i

                    if (user.size() > 0) // l9a user
                    // new ListReclamationForm(rs).show();//yemchi lel list reclamation
                    {
                        new ProfileForm(rs).show();
                    }

                }

            } catch (Exception ex) {
                ex.printStackTrace();
            }

        });

        //ba3d execution ta3 requete ely heya url nestanaw response ta3 server.
        NetworkManager.getInstance().addToQueueAndWait(req);
    }

    public void edit(String email, String firstname, String lastname, int age, String phonenumber, String gender, String adresse, Resources res) {

        String url = statics.BASE_URL + "/mobile/edit/" + SessionManager.getId() + "?email=" + email + "&firstname=" + firstname
                + "&lastname=" + lastname + "&age=" + age + "&telephone=" + phonenumber + "&gender=" + gender + "&addresse=" + adresse;
        req.setUrl(url);
        req.addResponseListener((e) -> {
            byte[] data = (byte[]) e.getMetaData();
            String responsedata = new String(data);
            System.out.print("datamod ====>" + responsedata);
        });

        NetworkManager.getInstance().addToQueueAndWait(req);

    }

    public User getCurrent(int id) {
        String url = statics.BASE_URL + "/mobile/cuser?id=" + id;
        req = new ConnectionRequest(url, false); //false ya3ni url mazlt matba3thtich lel server
        req.setUrl(url);
        User u = new User();
        req.addResponseListener((NetworkEvent e) -> {

            JSONParser j = new JSONParser();

            String json = new String(req.getResponseData()) + "";

            try {

                System.out.println("data ==" + json);
                Map<String, Object> user = j.parseJSON(new CharArrayReader(json.toCharArray()));
                //Session 
                String email = user.get("email").toString();
                String adresse = user.get("adresse").toString();
                String password = user.get("password").toString();
                String firstname = user.get("nom").toString();
                String lastname = user.get("prenom").toString();
                float age = Float.parseFloat(user.get("age").toString());
                float phonenumber = Float.parseFloat(user.get("telephone").toString());
                String image = user.get("image").toString();
                String gender = user.get("gender").toString();
                String role = user.get("roles").toString();

                u.setID(id);
                u.setAge((int) age);
                u.setEmail(email);
                u.setFirstname(firstname);
                u.setLastname(lastname);
                u.setImage(image);
                u.setPassword(password);
                u.setPhonenumber((int) phonenumber);
                u.setAdresse(adresse);
                u.setGender(gender);
                u.setRole(role);

            } catch (Exception ex) {
                ex.printStackTrace();
            }

        });

        //ba3d execution ta3 requete ely heya url nestanaw response ta3 server.
        NetworkManager.getInstance().addToQueueAndWait(req);
        return u;
    }

    public void delete(int id) {
        ConnectionRequest req1 = new ConnectionRequest();
        String url = statics.BASE_URL + "/mobile/deactivate?id=" + id;
        req1.setUrl(url);
        req1.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {

                req1.removeResponseCodeListener(this);
            }
        });

        NetworkManager.getInstance().addToQueueAndWait(req1);
    }

    public void editPassword(String password, int id) {
        String url = statics.BASE_URL + "/mobile/editpassword/?id=" + id + "&password=" + password;
        req.setUrl(url);
        req.addResponseListener((e) -> {
            byte[] data = (byte[]) e.getMetaData();
            String responsedata = new String(data);
            System.out.print("datamod ====>" + responsedata);
            System.out.print("test" + password);
        });

        NetworkManager.getInstance().addToQueueAndWait(req);
    }

    public String Random6Digits() {
        Random generator = new Random();
        generator.setSeed(System.currentTimeMillis());

        int num = generator.nextInt(99999) + 99999;
        if (num < 100000 || num > 999999) {
            num = generator.nextInt(99999) + 99999;
            if (num < 100000 || num > 999999) {
                try {
                    throw new Exception("Unable to generate PIN at this time..");
                } catch (Exception ex) {

                }
            }
        }
        String numm = "" + num + "";
        return numm;
    }

    public String getIdByEmail(String email, Resources rs) {

        String url = statics.BASE_URL + "/mobile/getidbyemail?email=" + email;
        req = new ConnectionRequest(url, false); //false ya3ni url mazlt matba3thtich lel server
        req.setUrl(url);

        req.addResponseListener((e) -> {

            JSONParser j = new JSONParser();

            json = new String(req.getResponseData()) + "";
            try {
                System.out.println("data ==" + json);
                Map<String, Object> password = j.parseJSON(new CharArrayReader(json.toCharArray()));
            } catch (Exception ex) {
                ex.printStackTrace();
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return json;
    }

    public void sendMail(User u, Resources res) {
        try {

            Properties props = new Properties();
            props.put("mail.transport.protocol", "smtp"); //SMTP protocol
            props.put("mail.smtps.host", "smtp.gmail.com"); //SMTP Host
            props.put("mail.smtps.auth", "true"); //enable authentication

            Session session = Session.getInstance(props, null); // aleh 9rahach 5ater mazlna masabinach javax.mail .jar

            MimeMessage msg = new MimeMessage(session);

            msg.setFrom(new InternetAddress("Reintialisation mot de passe <monEmail@domaine.com>"));
            msg.setRecipients(Message.RecipientType.TO, u.getEmail());
            msg.setSubject("Reset Password");
            msg.setSentDate(new Date(System.currentTimeMillis()));

            SessionManager.setCode(ServiceUser.getInstance().Random6Digits());

            String txt = "Welcome to WAKALNI : Please enter this code  : " + SessionManager.getCode() + " in the specified area and confirm to change your password";

            msg.setText(txt);

            SMTPTransport st = (SMTPTransport) session.getTransport("smtps");

            st.connect("smtp.gmail.com", 465, "malek.guemri@esprit.tn", "191JFT1237");

            st.sendMessage(msg, msg.getAllRecipients());

            System.out.println("server response : " + st.getLastServerResponse());

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void sendEMail(User u, String subject, String text) {
        try {

            Properties props = new Properties();
            props.put("mail.smtps.ssl.protocols", "TLSv1.2");
            props.put("mail.smtps.ssl.ciphersuites", "TLS_ECDHE_RSA_WITH_AES_128_CBC_SHA256");

            props.put("mail.transport.protocol", "smtp"); //SMTP protocol
            props.put("mail.smtps.host", "smtp.gmail.com"); //SMTP Host
            props.put("mail.smtps.auth", "true"); //enable authentication

            Session session = Session.getInstance(props, null); // aleh 9rahach 5ater mazlna masabinach javax.mail .jar

            MimeMessage msg = new MimeMessage(session);

            msg.setFrom(new InternetAddress("Reintialisation mot de passe <monEmail@domaine.com>"));
            msg.setRecipients(Message.RecipientType.TO, u.getEmail());
            msg.setSubject("Reset Password");
            msg.setSentDate(new Date(System.currentTimeMillis()));

            SessionManager.setCode(ServiceUser.getInstance().Random6Digits());

            String txt = "Welcome to WAKALNI : Please enter this code  : " + SessionManager.getCode() + " in the specified area and confirm to change your password";

            msg.setText(txt);

            SMTPTransport st = (SMTPTransport) session.getTransport("smtps");

            st.connect("smtp.gmail.com", 465, "malekguemri2@gmail.com", "23808542m");

            st.sendMessage(msg, msg.getAllRecipients());

            System.out.println("server response : " + st.getLastServerResponse());

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
