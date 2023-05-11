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
import com.mycompany.entities.Article;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceArticle;
import com.mycompany.services.ServiceUser;
import java.util.ArrayList;

/**
 *
 * @author allela
 */
public class ArticleForm extends SideMenuBaseForm {

    public ArticleForm(Resources res) {

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

        add(new Label("Articles", "TodayTitle"));
        ArrayList<Article> articles = new ArrayList<>();
        articles = ServiceArticle.getInstance().affichageArticle();

        for (Article a : articles) {
            TextField nom = new TextField(a.getNom(), "", 20, TextField.USERNAME);
            TextField cat = new TextField(a.getCategorie(), "", 20, TextField.USERNAME);
            TextField soucat = new TextField(a.getSous_categorie(), "", 20, TextField.USERNAME);
            TextField marque = new TextField(a.getMarque(), "", 20, TextField.USERNAME);
            TextField desc = new TextField(a.getDesc(), "", 20, TextField.USERNAME);
            TextField etat = new TextField(a.getEtat(), "", 20, TextField.USERNAME);
            nom.setEnabled(false);
            cat.setEnabled(false);
            soucat.setEnabled(false);
            marque.setEnabled(false);
            desc.setEnabled(false);
            etat.setEnabled(false);
            Button modButton = new Button("Modify");
            modButton.addActionListener(e -> {
                new ArticleEditForm(a.getId(),res).show();
            });
            Button delButton = new Button("Delete");
            delButton.addActionListener(e -> {
                if (Dialog.show("Warning", "The categorie will be permanently deleted, Are you sure ?", "Ok", "Cancel")) {
                    ServiceArticle.getInstance().deleteArticle(a.getId());
                    new ArticleForm(res).show();
                }
            });
            Button reviewButton = new Button("Add Review");
            reviewButton.addActionListener(e -> {
                new ReviewAddForm(res, a.getId()).show();
            });
            Button sreviewButton = new Button("Show Reviews");
            sreviewButton.addActionListener(e -> {
                new ReviewForm(res, a.getId()).show();
            });
            nom.getAllStyles().setMargin(LEFT, 0);
            cat.getAllStyles().setMargin(LEFT, 0);
            soucat.getAllStyles().setMargin(LEFT, 0);
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
                    BorderLayout.center(soucat).
                            add(BorderLayout.WEST, soucatIcon),
                    BorderLayout.center(marque).
                            add(BorderLayout.WEST, marqueIcon),
                    BorderLayout.center(etat).
                            add(BorderLayout.WEST, descIcon),
                    BorderLayout.center(desc).
                            add(BorderLayout.WEST, etatIcon),
                    BoxLayout.encloseX(modButton, delButton, sreviewButton, reviewButton)
            );
            add(by);
        }

        setupSideMenu(res);
    }

}
