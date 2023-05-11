/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.wakalni;

import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.Button;
import static com.codename1.ui.Component.LEFT;
import static com.codename1.ui.Component.RIGHT;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.FontImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.spinner.Picker;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.Jeux;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceJeux;
import com.mycompany.services.ServiceUser;

/**
 *
 * @author ahmed
 */
public class JeuxAddForm extends SideMenuBaseForm {

    public JeuxAddForm(Resources res) {

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
        Picker dp = new Picker();
        Picker dp1 = new Picker();
        dp.setType(Display.PICKER_TYPE_DATE);
        dp1.setType(Display.PICKER_TYPE_DATE);
        SimpleDateFormat smf = new SimpleDateFormat("yyyy-MM-dd");
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

        add(new Label("Add an jeux", "TodayTitle"));

        TextField type = new TextField("", "Type", 20, TextField.USERNAME);
        TextField titre = new TextField("", "Titre", 20, TextField.USERNAME);
        TextField image = new TextField("", "Image", 20, TextField.USERNAME);
        TextField datedebut = new TextField("", "Date debut", 20, TextField.USERNAME);
        TextField datefin = new TextField("", "Date fin", 20, TextField.USERNAME);
        TextField produit = new TextField("", "Produit", 20, TextField.USERNAME);
        TextField prix = new TextField("", "Prix", 20, TextField.USERNAME);

        Button addButton = new Button("ADD");
        addButton.addActionListener(e -> {
            if (Dialog.show("Succes", "The game will be added", "Ok", "Cancel")) {
                ServiceJeux.getInstance().ajouterJeux(new Jeux(type.getText(), titre.getText(), image.getText(), smf.format(dp.getDate()), smf.format(dp1.getDate()), produit.getText(), Float.parseFloat(prix.getText())));
                //new JeuxForm(res).show();
            }
        });
        type.getAllStyles().setMargin(LEFT, 0);
        titre.getAllStyles().setMargin(LEFT, 0);
        image.getAllStyles().setMargin(LEFT, 0);
        datedebut.getAllStyles().setMargin(LEFT, 0);
        datefin.getAllStyles().setMargin(LEFT, 0);
        produit.getAllStyles().setMargin(LEFT, 0);
        prix.getAllStyles().setMargin(LEFT, 0);
        Label typeIcon = new Label("", "TextField");
        Label titreIcon = new Label("", "TextField");
        Label imageIcon = new Label("", "TextField");
        Label datedIcon = new Label("", "TextField");
        Label datefIcon = new Label("", "TextField");
        Label produitIcon = new Label("", "TextField");
        Label prixIcon = new Label("", "TextField");
        typeIcon.getAllStyles().setMargin(RIGHT, 0);
        titreIcon.getAllStyles().setMargin(RIGHT, 0);
        imageIcon.getAllStyles().setMargin(RIGHT, 0);
        datedIcon.getAllStyles().setMargin(RIGHT, 0);
        datefIcon.getAllStyles().setMargin(RIGHT, 0);
        produitIcon.getAllStyles().setMargin(RIGHT, 0);
        prixIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(typeIcon, FontImage.MATERIAL_CATEGORY, 3);
        FontImage.setMaterialIcon(titreIcon, FontImage.MATERIAL_CATEGORY, 3);
        FontImage.setMaterialIcon(imageIcon, FontImage.MATERIAL_CATEGORY, 3);
        FontImage.setMaterialIcon(datedIcon, FontImage.MATERIAL_SHOP, 3);
        FontImage.setMaterialIcon(datefIcon, FontImage.MATERIAL_DESCRIPTION, 3);
        FontImage.setMaterialIcon(produitIcon, FontImage.MATERIAL_STAR, 3);
        FontImage.setMaterialIcon(prixIcon, FontImage.MATERIAL_STAR, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(type).
                        add(BorderLayout.WEST, typeIcon),
                BorderLayout.center(titre).
                        add(BorderLayout.WEST, titreIcon),
                BorderLayout.center(image).
                        add(BorderLayout.WEST, imageIcon),
                BorderLayout.center(dp).
                        add(BorderLayout.WEST, datedIcon),
                BorderLayout.center(dp1).
                        add(BorderLayout.WEST, datefIcon),
                BorderLayout.center(produit).
                        add(BorderLayout.WEST, produitIcon),
                BorderLayout.center(prix).
                        add(BorderLayout.WEST, prixIcon),
                
                addButton
        );
        add(by);

        setupSideMenu(res);
    }
}
