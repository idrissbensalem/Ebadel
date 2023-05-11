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
import com.codename1.ui.TextArea;
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
import java.util.Vector;

/**
 *
 * @author messoudi
 */
public class ReclamationAddForm extends SideMenuBaseForm {

    public ReclamationAddForm(Resources res/*, int idcommande*/) {

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

        add(new Label("Add a report Report", "TodayTitle"));

        Reclamation r = new Reclamation();
        TextField type = new TextField("", "Report Subject", 20, TextField.USERNAME);
        TextArea description = new TextArea("", 5, 5, TextField.USERNAME);
        Vector <String> vectorDest;
       vectorDest = new Vector();
       vectorDest.add("Service Client");
       vectorDest.add("Service Technique");
       vectorDest.add("Service commercial");
       ComboBox <String> destinataire = new ComboBox <> (vectorDest);
        description.setUIID("Toolbar");
       
        Button addButton = new Button("ADD");
        addButton.addActionListener(e -> {
            if (Dialog.show("Succes", "The report will be sent to be reviewed", "Ok", "Cancel")) {
                ServiceReclamation.getInstance().ajouterReclamation(new Reclamation(type.getText().toString(),description.getText().toString(),destinataire.getSelectedItem().toString(),SessionManager.getId()));
                //ServiceUser.getInstance().sendEMail(ServiceUser.getInstance().getCurrent(SessionManager.getId()), "Reclamation", "Votre reclamation est en cours de traitement, vous receverez un mail dès qu'elle est traité");
                new ReclamationForm(res).show();
            } else {
                new ReclamationForm(res).show();
            }
        });
        type.getAllStyles().setMargin(LEFT, 0);
        description.getAllStyles().setMargin(LEFT, 0);
        destinataire.getAllStyles().setMargin(LEFT, 0);
        Label typeIcon = new Label("", "TextField");
        Label descriptionIcon = new Label("", "TextField");
        Label destinataireIcon = new Label("", "TextField");
        typeIcon.getAllStyles().setMargin(RIGHT, 0);
        descriptionIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(typeIcon, FontImage.MATERIAL_SUBJECT, 3);
        FontImage.setMaterialIcon(descriptionIcon, FontImage.MATERIAL_EDIT, 3);
        FontImage.setMaterialIcon(destinataireIcon, FontImage.MATERIAL_EDIT, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(type).
                add(BorderLayout.WEST, typeIcon),
                BorderLayout.center(description).
                add(BorderLayout.WEST,descriptionIcon),
                BorderLayout.center(destinataire).
                add(BorderLayout.WEST,destinataireIcon),
                addButton
        );
        add(by);

        setupSideMenu(res);
    }

}
