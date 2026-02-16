import '../styles/LoginUser.css'
import Head from "../partials/Head.jsx";
import Footer from "../partials/Footer.jsx";
import { useState, useContext } from "react";
import { useNavigate } from "react-router-dom";
import { AuthContext } from "../context/AuthContext.jsx";

export default function LoginUser() {
    const navigate = useNavigate();
    const { setUser } = useContext(AuthContext);

    const [email, setEmail] = useState("");
    const [mdp, setMdp] = useState("");
    const [pseudo, setPseudo] = useState("");
    const [mode, setMode] = useState("login");
    const [error, setError] = useState(null);
    const [success, setSuccess] = useState(null);
    const [loading, setLoading] = useState(false);

    async function handleSubmit(e) {
        e.preventDefault();
        setError(null);
        setSuccess(null);
        setLoading(true);

        const API_BASE = "http://localhost:8000/auth";
        const endpoint = mode === "login" ? `${API_BASE}/login` : `${API_BASE}/register`;

        const bodyData = {
            email: email,
            password: mdp,
            ...(mode === "register" && { pseudo: pseudo })
        };

        try {
            const response = await fetch(endpoint, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(bodyData),
            });

            const data = await response.json();

            if (data.success) {
                setSuccess(mode === "login" ? "Connexion réussie !" : "Inscription réussie !");
                if (mode === "login") {
                    setUser(data.user);
                    setTimeout(() => navigate("/"), 1500);
                } else {
                    setMode("login");
                }
            } else {
                setError(data.message || "Une erreur est survenue.");
            }
        } catch (err) {
            setError("Impossible de contacter le serveur.");
        } finally {
            setLoading(false);
        }
    }

    return (
        <div className="login-container"> {/* Classe principale du CSS */}
            <Head />
            <main className="login-wrapper"> {/* Contenu centré */}
                <div className="login-card">
                    <h2 className="login-title">
                        {mode === "login" ? "Connexion" : "Créer un compte"}
                    </h2>

                    <form className='login-form' onSubmit={handleSubmit}>
                        {mode === "register" && (
                            <input
                                type='text'
                                placeholder='Pseudo'
                                value={pseudo}
                                onChange={e => setPseudo(e.target.value)}
                                required
                            />
                        )}

                        <input
                            type='email'
                            placeholder='Email'
                            value={email}
                            onChange={e => setEmail(e.target.value)}
                            required
                        />

                        <input
                            type='password'
                            placeholder='Mot de passe'
                            value={mdp}
                            onChange={e => setMdp(e.target.value)}
                            required
                        />

                        {error && <p className='error-message'>{error}</p>}
                        {success && <p className='success-message'>{success}</p>}

                        <button type='submit' className="btn-login" disabled={loading}>
                            {loading ? "Chargement..." : mode === "login" ? "Entrer dans Severum" : "S'inscrire"}
                        </button>
                    </form>

                    <div className="login-footer">
                        <p>
                            {mode === "login" ? "Pas encore de compte ?" : "Déjà inscrit ?"}
                            <button className="toggle-mode" onClick={() => setMode(mode === "login" ? "register" : "login")}>
                                {mode === "login" ? "Créer un compte" : "Se connecter"}
                            </button>
                        </p>
                    </div>
                </div>
            </main>
            <Footer />
        </div>
    );
}