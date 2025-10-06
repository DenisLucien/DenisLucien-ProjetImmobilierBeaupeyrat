import { Link } from "react-router-dom";
import logo from "@/assets/LimmoNoirBlanc.png";
import "./navbar.css";

export default function Navbar() {
  return (
    <nav>
      <img src={logo} alt="" className="navLogo"></img>
      <ul>
        <li>
          <Link to="/">Accueil</Link>
        </li>
        <li>
          <Link to="/about">À propos</Link>
        </li>
      </ul>
    </nav>
  );
}
