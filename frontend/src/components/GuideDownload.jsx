import '../styles/GuideDownload.css'
import Footer from "../partials/Footer.jsx";
import Head from "../partials/Head.jsx";

export default function GuideDownload () {
    return (
        <div className="guide-container">
            <Head />
            <main className="guide-wrapper">
                <h1 className="guide-download-title">
                    Guide d'installation cslol-manager
                </h1>
                <article className="guide-download">
                    <p className="guide-download-paragraph">
                        {/* Ton texte ici */}
                        Blablabla
                    </p>
                </article>
            </main>
            <Footer />
        </div>
    );
}