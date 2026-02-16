import '../styles/Nav.css'
import { useContext, useState } from "react";
import { AuthContext } from "../context/AuthContext";
import { Link, useNavigate } from "react-router-dom";

export default function Nav() {
    const [searchTerm, setSearchTerm] = useState("");
    const [champion, setChampion] = useState("");
    const [category, setCategory] = useState("");
    const [price, setPrice] = useState(100);
    // gérer la soumission du filtre
    const handleFilter = (e) => {
        e.preventDefault(); // Empêche le rechargement de la page
        const filters = { searchTerm, champion, category, price };
        console.log("Filtres envoyés :", filters);

        // Ici, vous pourriez appeler une API ou une fonction parente
    };

    return (
        <div className="navbar-wrapper">
            <nav className="navbar">
                <div className="search-bar-wrapper">
                    <label htmlFor="main-search">🔍 : </label>
                    <input
                        id="main-search"
                        name="search-bar"
                        type="search"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        placeholder="Rechercher..."
                    />
                </div>

                <div className="champion-search-wrapper">
                    <input
                        name="champion-search"
                        type="search"
                        value={champion}
                        onChange={(e) => setChampion(e.target.value)}
                        placeholder="Champion"
                    />
                </div>

                <div className="category-search-wrapper">
                    <input
                        name="category-search"
                        type="search"
                        placeholder="Catégorie"
                    />
                </div>

                <div className="price-range-wrapper">
                    <label htmlFor="price-range">
                        <label>
                            Prix : {price}€
                            <input
                                type="range"
                                min="1"
                                max="500"
                                value={price}
                                onChange={(e) => setPrice(e.target.value)}
                            />
                        </label>
                    </label>
                </div>

                <div className="filter-button-wrapper">
                    <button onClick={handleFilter}>Filtrer</button>
                </div>
            </nav>
        </div>
    );
}