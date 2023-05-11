/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.wakalni;

import com.codename1.io.Storage;
import com.codename1.ui.Button;
import static com.codename1.ui.Component.LEFT;
import static com.codename1.ui.Component.RIGHT;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceUser;

/**
 *
 * @author houssem
 */
public class ResetPasswordForm extends SideMenuBaseForm {

    public ResetPasswordForm(Resources res) {

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

        add(new Label("Change Password", "TodayTitle"));

        TextField password = new TextField("", "Password", 20, TextField.PASSWORD);
        TextField cpassword = new TextField("", "Confirm Password", 20, TextField.PASSWORD);
        Button editButton = new Button("Save");
        editButton.setUIID("LoginButton");
        editButton.addActionListener(e -> {
            if (password.getText().equals(cpassword.getText())) {

                ServiceUser.getInstance().editPassword(password.getText().toString(), SessionManager.getId() );
                System.out.print("aaaaaaaaa"+password.getText().toString());
                new ProfileForm(res).show();

            } else {
                Dialog.show("Failed", "Password must match", "Ok", null);
            }
        });

        password.getAllStyles().setMargin(LEFT, 0);
        cpassword.getAllStyles().setMargin(LEFT, 0);
        Label passwordIcon = new Label("", "TextField");
        Label cpasswordIcon = new Label("", "TextField");

        passwordIcon.getAllStyles().setMargin(RIGHT, 0);
        cpasswordIcon.getAllStyles().setMargin(RIGHT, 0);
        FontImage.setMaterialIcon(passwordIcon, FontImage.MATERIAL_LOCK, 3);
        FontImage.setMaterialIcon(cpasswordIcon, FontImage.MATERIAL_LOCK, 3);
        Container by = BoxLayout.encloseY(
                BorderLayout.center(password).
                add(BorderLayout.WEST, passwordIcon),
                BorderLayout.center(cpassword).
                add(BorderLayout.WEST, cpasswordIcon),
                editButton
        );
        add(by);
        setupSideMenu(res);
        
    }


}
