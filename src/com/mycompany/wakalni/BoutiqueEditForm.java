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
import com.mycompany.entities.User;
import com.mycompany.services.ServiceBoutique;
import com.mycompany.services.ServiceUser;

/**
 *
 * @author idriss
 */
public class BoutiqueEditForm extends SideMenuBaseForm {

    public BoutiqueEditForm(int id, Resources res) {

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
        Boutique a = ServiceBoutique.getInstance().getBoutique(id);

        tb.setTitleComponent(titleCmp);
        TextField nom = new TextField(a.getNom(), "", 20, TextField.USERNAME);
        TextField lien = new TextField(a.getLien(), "", 20, TextField.USERNAME);
        TextField telp = new TextField(a.getTelp(), "", 20, TextField.PHONENUMBER);
        TextField telf = new TextField(a.getTelf(), "", 20, TextField.PHONENUMBER);
        //TextField soucat = new TextField(a.getImage(), "", 20, TextField.USERNAME);
        TextField desc = new TextField(a.getDesc(), "", 20, TextField.USERNAME);
        TextField gouv = new TextField(a.getGouv(), "", 20, TextField.USERNAME);
        TextField ville = new TextField(a.getVille(), "", 20, TextField.USERNAME);
        Button addButton = new Button("Modify");
        addButton.addActionListener(e -> {
            if (Dialog.show("Succes", "The shop will be modified", "Ok", "Cancel")) {
                ServiceBoutique.getInstance().editBoutique(new Boutique(SessionManager.getId(), nom.getText(), lien.getText(), desc.getText(), telp.getText(),
                        telf.getText(), gouv.getText(), ville.getText()));
                new BoutiqueForm(res).show();
            }
        });

        lien.getAllStyles().setMargin(LEFT, 0);
        nom.getAllStyles().setMargin(LEFT, 0);
        telp.getAllStyles().setMargin(LEFT, 0);
        telf.getAllStyles().setMargin(LEFT, 0);
        desc.getAllStyles().setMargin(LEFT, 0);
        gouv.getAllStyles().setMargin(LEFT, 0);
        ville.getAllStyles().setMargin(LEFT, 0);
        Label lienIcon = new Label("", "TextField");
        Label nomIcon = new Label("", "TextField");
        Label telpIcon = new Label("", "TextField");
        Label telfIcon = new Label("", "TextField");
        Label descIcon = new Label("", "TextField");
        Label gouvIcon = new Label("", "TextField");
        Label villeIcon = new Label("", "TextField");
        lienIcon.getAllStyles().setMargin(RIGHT, 0);
        nomIcon.getAllStyles().setMargin(RIGHT, 0);
        telpIcon.getAllStyles().setMargin(RIGHT, 0);
        telfIcon.getAllStyles().setMargin(RIGHT, 0);
        descIcon.getAllStyles().setMargin(RIGHT, 0);
        gouvIcon.getAllStyles().setMargin(RIGHT, 0);
        villeIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(lienIcon, FontImage.MATERIAL_LINK, 3);
        FontImage.setMaterialIcon(nomIcon, FontImage.MATERIAL_SHOP, 3);
        FontImage.setMaterialIcon(telpIcon, FontImage.MATERIAL_PHONE, 3);
        FontImage.setMaterialIcon(telfIcon, FontImage.MATERIAL_PHONELINK, 3);
        FontImage.setMaterialIcon(descIcon, FontImage.MATERIAL_DESCRIPTION, 3);
        FontImage.setMaterialIcon(gouvIcon, FontImage.MATERIAL_HOME, 3);
        FontImage.setMaterialIcon(villeIcon, FontImage.MATERIAL_HOUSE, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(nom).
                        add(BorderLayout.WEST, nomIcon),
                BorderLayout.center(lien).
                        add(BorderLayout.WEST, lienIcon),
                BorderLayout.center(telp).
                        add(BorderLayout.WEST, telpIcon),
                BorderLayout.center(telf).
                        add(BorderLayout.WEST, telfIcon),
                BorderLayout.center(desc).
                        add(BorderLayout.WEST, descIcon),
                BorderLayout.center(gouv).
                        add(BorderLayout.WEST, gouvIcon),
                BorderLayout.center(ville).
                        add(BorderLayout.WEST, villeIcon),
                addButton
        );
        add(by);

        setupSideMenu(res);
    }

}
