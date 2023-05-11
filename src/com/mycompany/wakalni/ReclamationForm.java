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
import com.mycompany.entities.Reclamation;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceReclamation;
import com.mycompany.services.ServiceUser;
import java.util.ArrayList;

/**
 *
 * @author messoudi
 */
public class ReclamationForm extends SideMenuBaseForm {

    public ReclamationForm(Resources res) {

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

        add(new Label("Reports", "TodayTitle"));
        ArrayList<Reclamation> reclamations = new ArrayList<>();
        ArrayList<Reclamation> reclamationuser = new ArrayList<>();
        reclamations = ServiceReclamation.getInstance().affichageReclamation();

        for (Reclamation r : reclamations) {
            if (r.getUser() == SessionManager.getId()) {
                reclamationuser.add(r);
            }
        }
        for (Reclamation r : reclamationuser) {
            TextField type = new TextField(r.getType(), "", 20, TextField.USERNAME);
            TextField description = new TextField(r.getDescription(), "", 20, TextField.USERNAME);
            TextField destinataire = new TextField(r.getDestinataire(), "", 20, TextField.USERNAME);
            type.setEnabled(false);
            description.setEnabled(false);
            destinataire.setEnabled(false);
            Button delButton = new Button("Delete");
            delButton.addActionListener(e -> {
                if (Dialog.show("Warning", "The report will be permanently deleted, Are you sure ?", "Ok", "Cancel")) {
                    ServiceReclamation.getInstance().deleteReclamation(r.getId());
                    new ReclamationForm(res).show();
                }
            });
            Button modButton = new Button("Modify");
            modButton.addActionListener(e -> {
                    new ReclamationForm(res).show();       
            });
            type.getAllStyles().setMargin(LEFT, 0);
            description.getAllStyles().setMargin(LEFT, 0);
            destinataire.getAllStyles().setMargin(LEFT, 0);
            Label sujetIcon = new Label("", "TextField");
            Label contenuIcon = new Label("", "TextField");
            Label etatIcon = new Label("", "TextField");
            sujetIcon.getAllStyles().setMargin(RIGHT, 0);
            contenuIcon.getAllStyles().setMargin(RIGHT, 0);
            etatIcon.getAllStyles().setMargin(RIGHT, 0);
            FontImage.setMaterialIcon(sujetIcon, FontImage.MATERIAL_SUBJECT, 3);
            FontImage.setMaterialIcon(contenuIcon, FontImage.MATERIAL_EDIT, 3);
            FontImage.setMaterialIcon(etatIcon, FontImage.MATERIAL_VERIFIED, 3);
            Container by = BoxLayout.encloseY(
                    BorderLayout.center(type).
                    add(BorderLayout.WEST, sujetIcon),
                    BorderLayout.center(description).
                    add(BorderLayout.WEST, contenuIcon),
                    BorderLayout.center(destinataire).
                    add(BorderLayout.WEST, etatIcon),
                    delButton
            );
            add(by);
        }

        setupSideMenu(res);
    }

    
}
