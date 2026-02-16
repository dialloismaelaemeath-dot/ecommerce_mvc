import { useEffect, useState } from "react";
import "../styles/Panier.css"
import Footer from "../partials/Footer.jsx";
import Head from "../partials/Head.jsx";

const API_URL = "http://localhost:8000";

export default function Panier() {
    const [cart, setCart] = useState([]); // Initialise à tableau vide pour éviter les erreurs de .map
    const [loading, setLoading] = useState(true);

    const fetchCart = async () => {
        try {
            const res = await fetch(`${API_URL}/cart`, { credentials: "include" });
            const data = await res.json();
            // Utilise l'opérateur de chaînage optionnel pour plus de sécurité
            setCart(data.data?.items || []);
        } catch (error) {
            console.error("Erreur chargement panier", error);
            setCart([]);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchCart();
    }, []);

    const removeItem = async (productId) => {
        await fetch(`${API_URL}/cart/remove`, {
            method: "POST",
            credentials: "include",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id_produit: productId }) // Vérifie si c'est la clé attendue côté Symfony
        });
        fetchCart();
    };

    const updateQuantity = async (productId, quantity) => {
        if (quantity < 1) return; // Sécurité supplémentaire

        await fetch(`${API_URL}/cart/update`, {
            method: "POST",
            credentials: "include",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                id_produit: productId, // Harmonisé avec removeItem
                quantite: Number(quantity)
            })
        });
        fetchCart();
    };

    const total = cart.reduce(
        (sum, item) => sum + Number(item.produit.prix) * item.quantite,
        0
    );

    // ... (validateOrder identique)

    if (loading) return <p>Chargement du panier...</p>;

    return (
        <div className="cart-container"> {/* Classe principale pour le fond et la hauteur */}
            <Head/>

            <div className="cart-wrapper"> {/* Conteneur centré pour le contenu */}
                <div className="cart-header">
                    <h1>Votre Panier</h1>
                </div>

                {cart.length === 0 ? (
                    <div className="cart-empty">
                        <h2>Votre panier est vide.</h2>
                        <p>Explorez la boutique pour ajouter des articles !</p>
                    </div>
                ) : (
                    <>
                        <div className="cart-items">
                            {cart.map((item) => (
                                <div className="cart-item" key={item.produit.id_produit}>
                                    {/* Ajoute une image si tu en as une dans ton objet produit */}
                                    <div className="cart-item-details">
                                        <span className="cart-item-title">{item.produit.nom_produit}</span>
                                        <span className="cart-item-price">{item.produit.prix} €</span>
                                    </div>

                                    <div className="cart-item-quantity">
                                        <button className="quantity-btn"
                                                onClick={() => updateQuantity(item.produit.id_produit, item.quantite - 1)}>-
                                        </button>
                                        <span className="quantity-display">{item.quantite}</span>
                                        <button className="quantity-btn"
                                                onClick={() => updateQuantity(item.produit.id_produit, item.quantite + 1)}>+
                                        </button>
                                    </div>

                                    <button className="remove-btn" onClick={() => removeItem(item.produit.id_produit)}>
                                        Supprimer
                                    </button>
                                </div>
                            ))}
                        </div>

                        <div className="cart-summary">
                            <div className="cart-total">
                                <span>Total</span>
                                <span className="cart-total-amount">{total.toFixed(2)} €</span>
                            </div>
                            <div className="cart-actions">
                                <button className="btn btn-primary" onClick={validateOrder}>
                                    Valider la commande
                                </button>
                            </div>
                        </div>
                    </>
                )}
            </div>
            <Footer/>
        </div>
    );
}
