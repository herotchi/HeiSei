import { Yahoo } from "./yahoo.js";
import { Music } from "./music.js";

class Heisei {

    constructor() {
        this.yahoo = new Yahoo();
        this.music = new Music();
    }


    analysis (year, buttonTag) {
        this.yahoo.analysis(year, buttonTag);
        this.music.analysis(year);
    }
}

window.clickFunction  = (year, buttonTag) =>{
    const heisei = new Heisei();
    heisei.analysis(year, buttonTag);
}

