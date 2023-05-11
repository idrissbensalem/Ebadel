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
import com.mycompany.entities.Article;
import com.mycompany.entities.Marque;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceArticle;
import com.mycompany.services.ServiceUser;
import java.util.ArrayList;
import java.util.Vector;

/**
 *
 * @author allela
 */
public class ArticleEditForm extends SideMenuBaseForm {

    public ArticleEditForm(int id, Resources res) {

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

        add(new Label("Edit an article", "TodayTitle"));

        Vector<String> vectorCat = new Vector();
        Vector<String> vectorScat = new Vector();
        Vector<String> vectorMarque = new Vector();

        ArrayList<Marque> result = ServiceArticle.getInstance().getMarques();
        for (Marque c : result) {
            vectorMarque.add(String.valueOf(c.getId()));
            vectorCat.add(String.valueOf(c.getCat()));
            vectorScat.add(String.valueOf(c.getScat()));
        }
        ComboBox<String> cat = new ComboBox<>(vectorCat);
        ComboBox<String> scat = new ComboBox<>(vectorScat);
        ComboBox<String> marque = new ComboBox<>(vectorMarque);

        Article ar = ServiceArticle.getInstance().getArticle(id);
        
        TextField nom = new TextField(ar.getNom(), "Name", 20, TextField.USERNAME);
        TextField desc = new TextField(ar.getDesc(), "Description", 20, TextField.USERNAME);
        TextField etat = new TextField(ar.getEtat(), "Etat", 20, TextField.USERNAME);

        Button delButton = new Button("Edit");
        delButton.addActionListener(e -> {
            if (Dialog.show("Succes", "The article will be modified", "Ok", "Cancel")) {
                ServiceArticle.getInstance().editArticle(new Article(SessionManager.getId(), nom.getText(), etat.getText(), desc.getText()));
                new ArticleForm(res).show();
            }
        });

        nom.getAllStyles().setMargin(LEFT, 0);
        cat.getAllStyles().setMargin(LEFT, 0);
        scat.getAllStyles().setMargin(LEFT, 0);
        marque.getAllStyles().setMargin(LEFT, 0);
        desc.getAllStyles().setMargin(LEFT, 0);
        etat.getAllStyles().setMargin(LEFT, 0);
        Label nomIcon = new Label("", "TextField");
        Label catIcon = new Label("", "TextField");
        Label soucatIcon = new Label("", "TextField");
        Label marqueIcon = new Label("", "TextField");
        Label descIcon = new Label("", "TextField");
        Label etatIcon = new Label("", "TextField");
        nomIcon.getAllStyles().setMargin(RIGHT, 0);
        catIcon.getAllStyles().setMargin(RIGHT, 0);
        soucatIcon.getAllStyles().setMargin(RIGHT, 0);
        marqueIcon.getAllStyles().setMargin(RIGHT, 0);
        descIcon.getAllStyles().setMargin(RIGHT, 0);
        etatIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(nomIcon, FontImage.MATERIAL_CATEGORY, 3);
        FontImage.setMaterialIcon(catIcon, FontImage.MATERIAL_CATEGORY, 3);
        FontImage.setMaterialIcon(soucatIcon, FontImage.MATERIAL_CATEGORY, 3);
        FontImage.setMaterialIcon(marqueIcon, FontImage.MATERIAL_SHOP, 3);
        FontImage.setMaterialIcon(descIcon, FontImage.MATERIAL_DESCRIPTION, 3);
        FontImage.setMaterialIcon(etatIcon, FontImage.MATERIAL_STAR, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(nom).
                        add(BorderLayout.WEST, nomIcon),
                BorderLayout.center(cat).
                        add(BorderLayout.WEST, catIcon),
                BorderLayout.center(scat).
                        add(BorderLayout.WEST, soucatIcon),
                BorderLayout.center(marque).
                        add(BorderLayout.WEST, marqueIcon),
                BorderLayout.center(etat).
                        add(BorderLayout.WEST, descIcon),
                BorderLayout.center(desc).
                        add(BorderLayout.WEST, etatIcon),
                delButton
        );
        add(by);

        setupSideMenu(res);
    }

}
