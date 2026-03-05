
export default function Barsukas(props) {

    const style = {
        color: 'red',
        fontSize: '50px',
        fontWeight: 'bold',
    }

    return (
        <>
            <h2 className="go-green">As esu {props.koks} Barsukas</h2>
            <span>Mano vardas yra Barsukas, aš esu geras ir labai draugiškas. Aš myliu visus ir viską. Aš esu geriausias dalykas, kuris kada nors egzistavo. Aš esu geras Barsukas.</span>
            <h3 style={style}>As esu labai geras Barsukas</h3>

        </>
    );

}