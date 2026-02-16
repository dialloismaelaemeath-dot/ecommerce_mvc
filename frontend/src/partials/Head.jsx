import "../styles/Head.css"
import siteLogo from "../assets/logo-severum.png"
import cart from "../assets/cart.svg"
import profilLogo from "../assets/profil.svg"
import help from "../assets/help.svg"
import { Link, useNavigate } from "react-router-dom";


export default function Head () {


    return (
        <div className="head-wrapper">
            <div className="logo-section">
                <div className="logo-wrapper">
                    <Link to="/"><img src={siteLogo} alt="logo"/></Link>
                </div>
                <div className="title-wrapper">
                    <h1 className="title-homepage">Severum</h1>
                </div>
            </div>
            <div className="navbar-head">
                <div className="navbar-head-item">
                    <Link to="/panier"><img src={cart} alt="cart"/></Link>
                </div>
                <div className="navbar-head-item">
                    <Link to="/profil"><img src={profilLogo} alt="profile"/></Link>
                </div>
                <div className="navbar-head-item">
                    <Link to="/guide-download"><img src={help} alt="help"/></Link>
                </div>
            </div>
        </div>
    );
}