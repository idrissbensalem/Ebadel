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
import com.mycompany.entities.Categorie;
import com.mycompany.entities.Reclamation;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceCategorie;
import com.mycompany.services.ServiceReclamation;
import com.mycompany.services.ServiceUser;
import java.util.ArrayList;

/**
 *
 * @author amine
 */
public class CategorieForm extends SideMenuBaseForm{
    public CategorieForm(Resources res) {

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

        add(new Label("Categories", "TodayTitle"));
        ArrayList<Categorie> categories = new ArrayList<>();
        categories = ServiceCategorie.getInstance().affichageCategorie();

        for (Categorie r : categories) {
            TextField nom = new TextField(r.getNom(), "", 20, TextField.USERNAME);
            nom.setEnabled(false);
            Button delButton = new Button("Delete");
            delButton.addActionListener(e -> {
                if (Dialog.show("Warning", "The categorie will be permanently deleted, Are you sure ?", "Ok", "Cancel")) {
                    ServiceCategorie.getInstance().deleteCategorie(r.getId());
                    new CategorieForm(res).show();
                }
            });
            nom.getAllStyles().setMargin(LEFT, 0);
            Label nomIcon = new Label("", "TextField");
            nomIcon.getAllStyles().setMargin(RIGHT, 0);
            FontImage.setMaterialIcon(nomIcon, FontImage.MATERIAL_SUBJECT, 3);
            Container by = BoxLayout.encloseY(
                    BorderLayout.center(nom).
                    add(BorderLayout.WEST, nomIcon),
                    delButton
            );
            add(by);
        }

        setupSideMenu(res);
    }
}
