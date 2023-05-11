/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.wakalni;

import com.codename1.ui.Button;
import static com.codename1.ui.Component.LEFT;
import static com.codename1.ui.Component.RIGHT;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.Offre;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceOffre;
import com.mycompany.services.ServiceUser;

/**
 *
 * @author allela
 */
public class OffreAddForm extends SideMenuBaseForm {

    public OffreAddForm(Resources res) {

        super(BoxLayout.y());
        setUIID("Toolbar");
        User u = new User();
        u = ServiceUser.getInstance().getCurrent(SessionManager.getId());
        Toolbar tb = getToolbar();
        tb.setTitleCentered(false);
        Image profilePic = res.getImage("01.jpg");
        Image mask = res.getImage("round-mask.png");
        profilePic = profilePic.fill(mask.getWidth(), mask.getHeight());
        Label profilePicLabel = new Label(profilePic, "ProfilePicTitle");
        profilePicLabel.setMask(mask.createMask());

        Button menuButton = new Button("");
        menuButton.setUIID("Title");
        FontImage.setMaterialIcon(menuButton, FontImage.MATERIAL_MENU);
        menuButton.addActionListener(e -> getToolbar().openSideMenu());

        Container titleCmp = BoxLayout.encloseY(
                FlowLayout.encloseIn(menuButton),
                BorderLayout.centerAbsolute(
                        BoxLayout.encloseY(
                                new Label(u.getFirstname(), "Title"),
                                new Label(u.getEmail(), "SubTitle")
                        )
                ).add(BorderLayout.WEST, profilePicLabel)
        );

        tb.setTitleComponent(titleCmp);
        TextField article = new TextField("", "Article", 20, TextField.USERNAME);
        TextField marque = new TextField("", "Marque", 20, TextField.USERNAME);
        TextField titre = new TextField("", "Titre", 20, TextField.USERNAME);
        TextField image = new TextField("", "Image", 20, TextField.USERNAME);
        TextField pu = new TextField("", "Period utilisation", 20, TextField.USERNAME);
        TextField etat = new TextField("", "Etat", 20, TextField.USERNAME);
        TextField desc = new TextField("", "Description", 20, TextField.USERNAME);
        TextField pp = new TextField("", "Produit propose", 20, TextField.USERNAME);
        TextField bonus = new TextField("", "Bonus", 20, TextField.USERNAME);
        TextField tel = new TextField("", "Telephone", 20, TextField.USERNAME);
        Button addButton = new Button("ADD");
        addButton.addActionListener(e -> {
            if (Dialog.show("Succes", "The shop will be added", "Ok", "Cancel")) {
                ServiceOffre.getInstance().ajouterOffre(new Offre(SessionManager.getId(),Integer.parseInt(article.getText()),pp.getText(),pu.getText(),etat.getText(),
                desc.getText(),image.getText(),Float.parseFloat(bonus.getText()),tel.getText()));
                new ArticleForm(res).show();
            }
        });

        article.getAllStyles().setMargin(LEFT, 0);
        marque.getAllStyles().setMargin(LEFT, 0);
        titre.getAllStyles().setMargin(LEFT, 0);
        image.getAllStyles().setMargin(LEFT, 0);
        pu.getAllStyles().setMargin(LEFT, 0);
        etat.getAllStyles().setMargin(LEFT, 0);
        desc.getAllStyles().setMargin(LEFT, 0);
        pp.getAllStyles().setMargin(LEFT, 0);
        bonus.getAllStyles().setMargin(LEFT, 0);
        tel.getAllStyles().setMargin(LEFT, 0);
        Label articleIcon = new Label("", "TextField");
        Label marqueIcon = new Label("", "TextField");
        Label titreIcon = new Label("", "TextField");
        Label imageIcon = new Label("", "TextField");
        Label puIcon = new Label("", "TextField");
        Label etatIcon = new Label("", "TextField");
        Label descIcon = new Label("", "TextField");
        Label ppIcon = new Label("", "TextField");
        Label bonusIcon= new Label("", "TextField");
        Label telIcon = new Label("", "TextField");
        articleIcon.getAllStyles().setMargin(RIGHT, 0);
        marqueIcon.getAllStyles().setMargin(RIGHT, 0);
        titreIcon.getAllStyles().setMargin(RIGHT, 0);
        imageIcon.getAllStyles().setMargin(RIGHT, 0);
        puIcon.getAllStyles().setMargin(RIGHT, 0);
        etatIcon.getAllStyles().setMargin(RIGHT, 0);
        ppIcon.getAllStyles().setMargin(RIGHT, 0);
        bonusIcon.getAllStyles().setMargin(RIGHT, 0);
        bonusIcon.getAllStyles().setMargin(RIGHT, 0);
        telIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(articleIcon, FontImage.MATERIAL_PREVIEW, 3);
        FontImage.setMaterialIcon(marqueIcon, FontImage.MATERIAL_SHOP, 3);
        FontImage.setMaterialIcon(titreIcon, FontImage.MATERIAL_TITLE, 3);
        FontImage.setMaterialIcon(imageIcon, FontImage.MATERIAL_IMAGE, 3);
        FontImage.setMaterialIcon(puIcon, FontImage.MATERIAL_TIMER, 3);
        FontImage.setMaterialIcon(etatIcon, FontImage.MATERIAL_STAR, 3);
        FontImage.setMaterialIcon(descIcon, FontImage.MATERIAL_DESCRIPTION, 3);
        FontImage.setMaterialIcon(ppIcon, FontImage.MATERIAL_PRODUCTION_QUANTITY_LIMITS, 3);
        FontImage.setMaterialIcon(bonusIcon, FontImage.MATERIAL_PRICE_CHECK, 3);
        FontImage.setMaterialIcon(telIcon, FontImage.MATERIAL_PHONE, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(article).
                        add(BorderLayout.WEST, articleIcon),
                BorderLayout.center(marque).
                        add(BorderLayout.WEST, marqueIcon),
                BorderLayout.center(titre).
                        add(BorderLayout.WEST, titreIcon),
                BorderLayout.center(desc).
                        add(BorderLayout.WEST, descIcon),
                BorderLayout.center(etat).
                        add(BorderLayout.WEST, etatIcon),
                BorderLayout.center(desc).
                        add(BorderLayout.WEST, descIcon),
                BorderLayout.center(pp).
                        add(BorderLayout.WEST, ppIcon),
                BorderLayout.center(bonus).
                        add(BorderLayout.WEST, bonusIcon),
                BorderLayout.center(tel).
                        add(BorderLayout.WEST, telIcon),
                BorderLayout.center(image).
                        add(BorderLayout.WEST, imageIcon),
                addButton
        );
        add(by);

        setupSideMenu(res);
    }
    
}
