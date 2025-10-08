import { Link } from "react-router-dom";
import logo from "@/assets/LimmoNoirBlanc.png";
import "./navbar.css";

export default function Navbar() {
  return (
    <nav>
      <img src={logo} alt="" className="navLogo"></img>
      <ul className="navLinks">
        <li>
          <Link to="/">Accueil</Link>
        </li>
        <li>
          <Link to="/about">À propos</Link>
        </li>
        <li>
          <Link to="/Chat">Chat</Link>
        </li>
        <li>
          <Link to="/login">Se connecter</Link>
        </li>
      </ul>
    </nav>
  );
}
