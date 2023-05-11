/*
 * Copyright (c) 2016, Codename One
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated 
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation 
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
 * and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions 
 * of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 */
package com.mycompany.wakalni;

import com.codename1.components.ToastBar;
import com.codename1.io.Storage;
import com.codename1.ui.Container;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.Layout;
import com.codename1.ui.util.Resources;
import com.mycompany.entities.User;
import com.mycompany.services.ServiceUser;

/**
 *
 * @author houssem
 */
public abstract class SideMenuBaseForm extends Form {

    public SideMenuBaseForm(String title, Layout contentPaneLayout) {
        super(title, contentPaneLayout);
    }

    public SideMenuBaseForm(String title) {
        super(title);
    }

    public SideMenuBaseForm() {
    }

    public SideMenuBaseForm(Layout contentPaneLayout) {
        super(contentPaneLayout);
    }

    public void setupSideMenu(Resources res) {
        User u = ServiceUser.getInstance().getCurrent(SessionManager.getId());
        System.out.println("aa" + u.getRole());
        Image profilePic = res.getImage("01.jpg");
        Image mask = res.getImage("round-mask.png");
        mask = mask.scaledHeight(mask.getHeight() / 4 * 3);
        profilePic = profilePic.fill(mask.getWidth(), mask.getHeight());
        Label profilePicLabel = new Label(u.getFirstname() + " " + u.getLastname(), profilePic, "SideMenuTitle");
        profilePicLabel.setMask(mask.createMask());

        Container sidemenuTop = BorderLayout.center(profilePicLabel);
        sidemenuTop.setUIID("SidemenuTop");
        getToolbar().addComponentToSideMenu(sidemenuTop);
        if ("[ROLE_USER]".equals(u.getRole())) {
            getToolbar().addMaterialCommandToSideMenu("  Profile", FontImage.MATERIAL_PERSON, e -> new ProfileForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  My Reports", FontImage.MATERIAL_EDIT, e -> new ReclamationForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add Reports", FontImage.MATERIAL_ADD_TASK, e -> new ReclamationAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add Articles", FontImage.MATERIAL_ADD_TASK, e -> new ArticleAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  My Articles", FontImage.MATERIAL_ADD_TASK, e -> new ArticleForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  All games", FontImage.MATERIAL_ADD_TASK, e -> new JeuxForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add shop", FontImage.MATERIAL_ADD_TASK, e -> new BoutiqueAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  All shops", FontImage.MATERIAL_ADD_TASK, e -> new BoutiqueForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  All products", FontImage.MATERIAL_ADD_TASK, e -> new ProduitForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Logout", FontImage.MATERIAL_EXIT_TO_APP, e -> {
                new LoginForm(res).show();
                SessionManager.pref.clearAll();
                Storage.getInstance().clearStorage();
                Storage.getInstance().clearCache();

            });
            refreshTheme();
        } else {
            
            getToolbar().addMaterialCommandToSideMenu("  Profile", FontImage.MATERIAL_PERSON, e -> new ProfileForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  My Reports", FontImage.MATERIAL_EDIT, e -> new ReclamationForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add Reports", FontImage.MATERIAL_ADD_TASK, e -> new ReclamationAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add Categories", FontImage.MATERIAL_ADD_TASK, e -> new CategorieAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  All Categories", FontImage.MATERIAL_ADD_TASK, e -> new CategorieForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add Articles", FontImage.MATERIAL_ADD_TASK, e -> new ArticleAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  My Articles", FontImage.MATERIAL_ADD_TASK, e -> new ArticleForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  All games", FontImage.MATERIAL_ADD_TASK, e -> new JeuxForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add game", FontImage.MATERIAL_ADD_TASK, e -> new JeuxAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add shop", FontImage.MATERIAL_ADD_TASK, e -> new BoutiqueAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  All shops", FontImage.MATERIAL_ADD_TASK, e -> new BoutiqueForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Add product", FontImage.MATERIAL_ADD_TASK, e -> new ProduitAddForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  All products", FontImage.MATERIAL_ADD_TASK, e -> new ProduitForm(res).show());
            getToolbar().addMaterialCommandToSideMenu("  Logout", FontImage.MATERIAL_EXIT_TO_APP, e -> {
                new LoginForm(res).show();
                SessionManager.pref.clearAll();
                Storage.getInstance().clearStorage();
                Storage.getInstance().clearCache();

            });
            refreshTheme();
        }

    }
}
