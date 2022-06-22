<?php


namespace app\core;


class Config
{
    static array $routes =
        [
            //** PUBLIC **//
            ['GET', '/', "index#index", 'home'],

            // #PRODUCT
            ['GET', '/nos-produits', "product#index" , 'product'],

                // #ARTICLE
            ['GET', '/nouveautes', "article#index", 'article'],

            //** BACKEND **//
            ['GET | POST ', '/editeur', "index#admin", 'adminHome'],

                // #AUTH
            ['GET | POST ', '/editeur/connexion', "user#login", 'adminLogin'],
            ['GET', '/editeur/deconnexion', "user#logOut", 'userLogOut'],

                // #ARTICLE
            ['GET | POST ', '/editeur/article-maj/[i:id]', "article#adminUpdate", 'articleUpdate'],
            ['GET | POST ', '/editeur/article-ajout', "article#adminInsert", 'articleInsert'],
            ['GET | POST ', '/editeur/article-suppr/[i:id]', "article#adminDelete", 'articleDelete'],

                // #PRODUCT
            ['GET | POST ', '/editeur/produit-maj/[i:id]', "product#adminUpdate", 'productUpdate'],
            ['GET | POST ', '/editeur/produit-ajout', "product#adminInsert", 'productInsert'],
            ['GET | POST ', '/editeur/produit-suppr/[i:id]', "product#adminDelete", 'productDelete'],

                // #BASKET
            ['GET | POST ', '/editeur/panier-maj/[i:id]', "basket#adminUpdate", 'basketUpdate'],
            ['GET | POST ', '/editeur/panier-ajoutdeproduit/[i:id]', "basket#adminAddProduct", 'basketAdd'],

        ];
}
