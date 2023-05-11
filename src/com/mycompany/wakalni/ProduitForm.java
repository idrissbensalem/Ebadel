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
import com.mycompany.entities.Boutique;
import com.mycompany.entities.Produit;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceBoutique;
import com.mycompany.services.ServiceProduit;
import com.mycompany.services.ServiceUser;
import java.util.ArrayList;

/**
 *
 * @author idriss
 */
public class ProduitForm extends SideMenuBaseForm {

    public ProduitForm(Resources res) {

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

        add(new Label("Produits", "TodayTitle"));
        ArrayList<Produit> produits = new ArrayList<>();
        produits = ServiceProduit.getInstance().affichageProduit();
        
        for (Produit a : produits) {
            Boutique b = ServiceBoutique.getInstance().getBoutique(a.getBoutique());
            TextField boutique = new TextField(b.getNom(), "Boutique", 20, TextField.USERNAME);
            //TextField image = new TextField("", "Marque", 20, TextField.USERNAME);
            TextField titre = new TextField(a.getTitre(), "Title", 20, TextField.USERNAME);
            TextField prix = new TextField(String.valueOf(a.getPrix()), "Price", 20, TextField.NUMERIC);
            boutique.setEnabled(false);
            //image.setEnabled(false);
            titre.setEnabled(false);
            prix.setEnabled(false);
            Button delButton = new Button("Delete");
            delButton.addActionListener(e -> {
                if (Dialog.show("Warning", "The product will be permanently deleted, Are you sure ?", "Ok", "Cancel")) {
                    ServiceProduit.getInstance().deleteProduit(a.getId());
                    new ProduitForm(res).show();
                }
            });
            Button modButton = new Button("Modify");
            modButton.addActionListener(e -> {
                    new ProduitEditForm(a.getId(),res).show();
            });
            boutique.getAllStyles().setMargin(LEFT, 0);
            //image.getAllStyles().setMargin(LEFT, 0);
            titre.getAllStyles().setMargin(LEFT, 0);
            prix.getAllStyles().setMargin(LEFT, 0);
            Label boutiqueIcon = new Label("", "TextField");
            Label imageIcon = new Label("", "TextField");
            Label titreIcon = new Label("", "TextField");
            Label prixIcon = new Label("", "TextField");
            boutiqueIcon.getAllStyles().setMargin(RIGHT, 0);
            imageIcon.getAllStyles().setMargin(RIGHT, 0);
            titreIcon.getAllStyles().setMargin(RIGHT, 0);
            prixIcon.getAllStyles().setMargin(RIGHT, 0);
            FontImage.setMaterialIcon(boutiqueIcon, FontImage.MATERIAL_SHOP, 3);
            FontImage.setMaterialIcon(imageIcon, FontImage.MATERIAL_PHOTO, 3);
            FontImage.setMaterialIcon(titreIcon, FontImage.MATERIAL_TITLE, 3);
            FontImage.setMaterialIcon(prixIcon, FontImage.MATERIAL_MONEY, 3);
            Container by = BoxLayout.encloseY(
                    BorderLayout.center(boutique).
                            add(BorderLayout.WEST, boutiqueIcon),
                    BorderLayout.center(titre).
                            add(BorderLayout.WEST, titreIcon),
                    BorderLayout.center(prix).
                            add(BorderLayout.WEST, prixIcon),
                    delButton
            );
            add(by);
        }

        setupSideMenu(res);
    }
}
