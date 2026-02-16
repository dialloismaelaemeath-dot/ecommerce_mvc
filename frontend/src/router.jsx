import DetailProduit from "./components/DetailProduit.jsx";
import GuideDownload from "./components/GuideDownload.jsx";
import Panier from "./components/Panier.jsx";
import Profil from "./components/Profil.jsx";
import Homepage from "./Homepage.jsx";
import LoginUser from "./components/LoginUser.jsx";
import {Routes, Route} from 'react-router-dom';

export default function AppRouter() {
    return (
        <Routes>
            <Route path="/login" element={<LoginUser />}/>
            <Route path="/" element={<Homepage />}/>
            <Route path="/panier" element={<Panier />}/>
            <Route path="/detail/:id" element={<DetailProduit />}/>
            <Route path="/guide-download" element={<GuideDownload />}/>
            <Route path="/profil" element={<Profil />}/>
        </Routes>
    );
}