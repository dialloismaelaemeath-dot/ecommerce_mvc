import "../styles/Profil.css"
import Head from "../partials/Head.jsx";
import Footer from '../partials/Footer.jsx'
import { useEffect, useState } from "react";

const API_URL = "http://localhost:8000"

export default function Profil () {
    const [user, setUser] = useState({
        pseudo: "",
        bio: "",
        avatar_url: "",
        role: []
    });
    const [loading, setLoading] = useState(true);

    const fetchUserInfo = async () => {
        try {
            const res = await fetch(`${API_URL}/user/info`, { credentials: "include" });
            const data = await res.json();
            if (data.success) {
                setUser({
                    pseudo: data.data.pseudo,
                    bio: data.data.bio,
                    avatar_url: data.data.avatar_url,
                    role: data.data.role
                });
            }
        } catch (error) {
            console.error("Erreur lors du chargement des infos.", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchUserInfo();
    }, []);

    if (loading) return <div className="profile-container"><p>Chargement du profil...</p></div>;

    return (
        <div className="profile-container"> {/* Correspond au CSS */}
            <Head />
            <div className="profile-wrapper"> {/* Correspond au CSS */}
                <div className="profile-card"> {/* Structure standard pour ton CSS */}
                    <div className="profile-avatar-section">
                        <img
                            src={user.avatar_url || "/default-avatar.png"}
                            alt={`Avatar de ${user.pseudo}`}
                        />
                    </div>

                    <div className="profile-info-section">
                        <div className="profile-header-info">
                            <h2 className="profile-pseudo">{user.pseudo}</h2>
                            {user.role.includes("ROLE_SELLER") && <span className="badge">Vendeur</span>}
                        </div>

                        <div className="profile-bio-box">
                            <p className="bio-label">Ma Bio :</p>
                            <textarea
                                className="profile-textarea"
                                value={user.bio}
                                readOnly
                            />
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    );
}