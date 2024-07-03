export class Music 
{
    constructor() {
        this.year = null;
    }

    analysis(year) {
        this.year = year;
        this.fetchYoutube();
    }

    async fetchYoutube() {
        console.log(this.year);
    }
}