/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.wakalni;

import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
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
import java.util.Vector;

/**
 *
 * @author idriss
 */
public class ProduitEditForm extends SideMenuBaseForm {

    public ProduitEditForm(int id, Resources res) {

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

        add(new Label("Add a product", "TodayTitle"));
        ArrayList<Boutique> result = new ArrayList<>();

        Vector<String> vectorB;
        vectorB = new Vector();
        result = ServiceBoutique.getInstance().affichageBoutique();
        for (Boutique c : result) {
            vectorB.add(String.valueOf(c.getId()));
        }
        Produit p = ServiceProduit.getInstance().getProduit(id);
        ComboBox<String> boutique = new ComboBox<>(vectorB);
        TextField titre = new TextField(p.getTitre(), "Title", 20, TextField.USERNAME);
        TextField prix = new TextField(String.valueOf(p.getPrix()), "Price", 20, TextField.USERNAME);

        Button addButton = new Button("Modify");
        addButton.addActionListener(e -> {
            if (Dialog.show("Succes", "The produit will be added", "Ok", "Cancel")) {
                ServiceProduit.getInstance().ajouterProduit(new Produit(p.getId(), Integer.parseInt(boutique.getSelectedItem()), titre.getText(), Float.parseFloat(prix.getText())));
                new ProduitForm(res).show();
            }
        });
        boutique.getAllStyles().setMargin(LEFT, 0);
        titre.getAllStyles().setMargin(LEFT, 0);
        prix.getAllStyles().setMargin(LEFT, 0);
        Label boutiqueIcon = new Label("", "TextField");
        Label titreIcon = new Label("", "TextField");
        Label prixIcon = new Label("", "TextField");
        boutiqueIcon.getAllStyles().setMargin(RIGHT, 0);
        titreIcon.getAllStyles().setMargin(RIGHT, 0);
        prixIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(boutiqueIcon, FontImage.MATERIAL_SHOP, 3);
        FontImage.setMaterialIcon(titreIcon, FontImage.MATERIAL_TITLE, 3);
        FontImage.setMaterialIcon(prixIcon, FontImage.MATERIAL_MONEY, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(boutique).
                        add(BorderLayout.WEST, boutiqueIcon),
                BorderLayout.center(titre).
                        add(BorderLayout.WEST, titreIcon),
                BorderLayout.center(prix).
                        add(BorderLayout.WEST, prixIcon),
                addButton
        );
        add(by);

        setupSideMenu(res);
    }
    
}
