class HeiSei
{

}

function test(year, buttonTag) {
    const text = buttonTag.textContent || buttonTag.innerText;

    //fetchYahoo();
    test2();
    
}


function test2() {
    console.log('test2');
}

/*
async function fetchYahoo(year, text) {

    const url = './api/search';
    const body = {
        year: year,
        text: text
    };

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(body) 
        });
    } catch (error) {
        showToast('通信に失敗しました。');
    }
    
}*/