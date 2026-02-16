import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import './styles/Homepage.css';
import Nav from "./partials/Nav.jsx";
import Head from "./partials/Head.jsx";
import Footer from "./partials/Footer.jsx";

const API_URL = "http://localhost:8000";

function Homepage() {
    const navigate = useNavigate();
    const [productsPop, setProductsPop] = useState([]);
    const [productsReduc, setProductsReduc] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            try {
                setLoading(true);
                const [resPop, resReduc] = await Promise.all([
                    fetch(`${API_URL}/products/pop`, { credentials: "include" }),
                    fetch(`${API_URL}/products/reduc`, { credentials: "include" })
                ]);

                const dataPop = await resPop.json();
                const dataReduc = await resReduc.json();

                if (dataPop.success) setProductsPop(dataPop.data);
                if (dataReduc.success) setProductsReduc(dataReduc.data);

            } catch (error) {
                console.error("Erreur chargement produits :", error);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    if (loading) {
        return <div className="loading">Chargement des skins...</div>;
    }

    return (
        <div className="home-wrapper">
            <Head/>
            <Nav/>
            <div className="product-pop-carrousel-wrapper">
                <h3 className="products-pop-title">Skins Populaires</h3>
                <ul className="product-carrousel-pop">
                    {productsPop.length > 0 ? productsPop.map(product => (
                        <ProductCard key={product.id_produit} product={product} navigate={navigate} />
                    )) : <p>Aucun produit populaire trouvé.</p>}
                </ul>
            </div>
            <div className="product-reduc-carrousel-wrapper">
                <h3 className="products-reduc-title">Skins en Promo</h3>
                <ul className="product-carrousel-reduc">
                    {productsReduc.length > 0 ? productsReduc.map(product => (
                        <ProductCard key={product.id_produit} product={product} navigate={navigate} />
                    )) : <p>Aucune promotion actuellement.</p>}
                </ul>
            </div>

            <Footer />
        </div>
    );
}

function ProductCard({ product, navigate }) {
    return (
        <li className="product-item">
            <span>{product.nom_produit}</span>
            <div className="product-img-container">
                <img src={product.image_produit} alt={product.nom_produit}/>
            </div>
            <button
                className="product-more-btn"
                onClick={() => navigate(`/detail/${product.id_produit}`)}
            >
                En savoir plus
            </button>
        </li>
    );
}

export default Homepage;