import Navbar from "../Navbar";
import "./header.css";
import headerPic from "@/assets/headerpic.jpg";

export default function Header() {
  return (
    <div className="header">
      <Navbar />
      <img src={headerPic} alt="" className="headerPicture"></img>
    </div>
  );
}
