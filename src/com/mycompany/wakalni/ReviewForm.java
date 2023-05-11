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
import com.codename1.ui.FontImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.Review;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceReview;
import com.mycompany.services.ServiceUser;
import java.util.ArrayList;

/**
 *
 * @author messaoudi
 */
public class ReviewForm extends SideMenuBaseForm {

    public ReviewForm(Resources res, int idart) {

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

        add(new Label("Reviews", "TodayTitle"));
        
        ArrayList<Review> reviews = new ArrayList<>();
        reviews = ServiceReview.getInstance().affichageReview();
        ArrayList<Review> artreviews = new ArrayList<>();
        
        Label ratel = new Label("Rating /5 : ");
        Label rate = new Label(ServiceReview.getInstance().getRating(idart));
        add(BoxLayout.encloseX(ratel,rate));
        
        for (Review r : reviews) {
            if (r.getArticle()== idart) {
                artreviews.add(r);
            }
        }
        for (Review r : artreviews) {
            //TextField article = new TextField(ServiceArticle.getInstance().getArticle(r.getArticle()).getNom(), "", 20, TextField.USERNAME);
            TextField cmnt = new TextField(r.getComments(), "", 20, TextField.USERNAME);
            cmnt.setEnabled(false);
            cmnt.getAllStyles().setMargin(LEFT, 0);
            Label sujetIcon = new Label("", "TextField");
            sujetIcon.getAllStyles().setMargin(RIGHT, 0);
            FontImage.setMaterialIcon(sujetIcon, FontImage.MATERIAL_SUBJECT, 3);
            Container by = BoxLayout.encloseY(
                    BorderLayout.center(cmnt).
                            add(BorderLayout.WEST, sujetIcon)
            );
            add(by);
        }

        setupSideMenu(res);
    }

}
