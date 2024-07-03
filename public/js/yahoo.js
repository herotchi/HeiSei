class Yahoo 
{
    constructor() {
        this.year = null;
        this.text = '';
    }

    analysis(year, buttonTag) {
        this.year = year;
        this.text = buttonTag.textContent || buttonTag.innerText;
        this.fetchYahoo();
    }

    async fetchYahoo() {

        const url = './api/analysis';
        const body = {
            text: this.text
        };

        await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        })
        .then(response => response.json())
        .then(data => {
            this.removeSameNounsList();
            this.displaySameNounsList(data);
        })
        .catch(error => {
            console.error('Error:', error);
            this.showToast('通信に失敗しました。');
        });
    }


    removeSameNounsList() {
        const parentDiv = document.getElementById('nouns');
        parentDiv.innerHTML = '';
    }


    displaySameNounsList(list) {
        const parentDiv = document.getElementById('nouns');
        const childDiv = document.createElement('div');
        childDiv.id = 'nounsChild';
        childDiv.className = 'accordion';
        parentDiv.appendChild(childDiv);
        for (const key in list) {
            if (list[key].length > 0) {
                const accordionItemDiv = document.createElement('div');
                accordionItemDiv.className = 'accordion-item';
                childDiv.appendChild(accordionItemDiv);

                const h2 = document.createElement('h2');
                h2.className = 'accordion-header';
                accordionItemDiv.appendChild(h2);

                const accordionButton = document.createElement('button');
                accordionButton.type = 'button';
                accordionButton.className = 'accordion-button collapsed';
                accordionButton.setAttribute('data-bs-toggle', 'collapse');
                accordionButton.setAttribute('data-bs-target', `#${key}`);
                accordionButton.setAttribute('aria-expanded', false);
                accordionButton.setAttribute('aria-controls', key);
                accordionButton.innerText = key;
                h2.appendChild(accordionButton);

                const accordionCoppapseDiv = document.createElement('div');
                accordionCoppapseDiv.id = key;
                accordionCoppapseDiv.className = 'accordion-collapse collapse';
                accordionCoppapseDiv.setAttribute('data-bs-parent', '#nounsChild');
                accordionItemDiv.appendChild(accordionCoppapseDiv);

                const accordionBodyDiv = document.createElement('div');
                accordionBodyDiv.className = 'accordion-body';
                accordionCoppapseDiv.appendChild(accordionBodyDiv);

                const ul = document.createElement('ul');
                ul.className = 'list-group';
                accordionBodyDiv.appendChild(ul);

                list[key].forEach(news => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    let date = `${news['year']}年${news['month']}月`;
                    if (news['day']) {console.log(news['day']);
                        date += `${news['day']}日`;
                    }
                    li.innerText = date;
                    ul.appendChild(li);

                    const contextDiv = document.createElement('div');
                    contextDiv.className = 'text-start px-2 py-1';
                    contextDiv.innerText = news['context'];
                    li.appendChild(contextDiv);
                });
            }
        }
    }


    showToast(message) {
        const toastEl = document.getElementById('toast');
        const toast = new bootstrap.Toast(toastEl);
        const element = toastEl.querySelector('.toast-body');
        element.textContent  = message;
        toast.show();
    }

    
}

const yahoo = new Yahoo();