export class Music 
{
    constructor() {
        this.year = null;
        this.yearData = null;
        this.keyword = '';
        this.idList = {};

        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

    async analysis(year) {
        this.year = year;
        
        await this.fetchYearData();
        this.displayMusicSelector();
    }

    async fetchYearData() {
        try {
            const response = await fetch(`./music/${this.year}.json`);
            this.yearData = await response.json();
        } catch (error) {
            this.showToast('読み込みに失敗しました。');
        }
    }


    displayMusicSelector() {
        const musicSel = document.getElementById('music');
        musicSel.innerHTML = `<option value="">---</option>`;
        this.yearData.forEach(entry => {
            let option = document.createElement('option');
            option.value = `${entry.artist} ${entry.song}`;
            option.text = `${entry.rank}位 ${entry.artist}：${entry.song}`;
            musicSel.add(option);
        });

        musicSel.addEventListener('change' , (event) => {
            if (event.target.value !== '') {
                this.keyword = event.target.value;
                // 既に存在するiframeタグを削除する
                const playlistDiv = document.getElementById('playlist');
                while (playlistDiv.firstChild) {
                    playlistDiv.removeChild(playlistDiv.firstChild);
                }

                this.searchYouTube();


            } else {

            }
        });
    }


    async searchYouTube()
    {
        try {
            const response = await fetch(`./api/youtube?keyword=${this.keyword}`);
            const data = await response.json();
            if (data.errors) {
                this.showToast('入力エラーです。');
            } else {
                this.idList = data.idList;console.log(data.idList);
                await this.setVideos();
            }
        } catch (error) {console.log(error);
            this.showToast('通信に失敗しました。');
        }
    }

    async setVideos() {
        window.onYouTubeIframeAPIReady = this.onYouTubeIframeAPIReady.bind(this);

        const playlist = document.getElementById('playlist');
        for (let i = 0; i < this.idList.length; i++) {
            const newDiv = document.createElement('div');
            newDiv.id = `player${i}`;
            newDiv.className = 'player mt-3';
            playlist.appendChild(newDiv);
            this.onYouTubeIframeAPIReady(`player${i}`, this.idList[i]);
        }
    }

    onYouTubeIframeAPIReady(id, videoId) {

        const playlistEl = document.getElementById('playlist');
        const style = getComputedStyle(playlistEl);
        const paddingLeft = parseFloat(style.paddingLeft);
        const paddingRight = parseFloat(style.paddingRight);
    
        // clientWidth から padding を除いた幅を計算
        const widthWithoutPadding = playlistEl.clientWidth - paddingLeft - paddingRight;

        // プレイヤーを初期化
        this.player = new YT.Player(id, {
            videoId: videoId,
            width: widthWithoutPadding
        });
    }


    showToast(message) {
        const toastEl = document.getElementById('toast');
        const toast = new bootstrap.Toast(toastEl);
        const element = toastEl.querySelector('.toast-body');
        element.textContent  = message;
        toast.show();
    }

}