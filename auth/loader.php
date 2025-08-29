<style>
.loader{
    position:fixed;
    top:0;
    left:0;
    background:white;
    height:100%;
    width:100%;
    display:none;
}

.loader_content{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:40px;
    flex-direction:column;
}

.loader_logo img{
    width:150px;
}

.loader_spinner{
    text-align:center;
    width:50px;
}

.loader_text{
    text-align:center;
    }
</style>
<div class="loader">
    <div class="loader_content">
        <div class="loader_logo">
            <img src="res/img/logo.png">
        </div>
        <div class="loader_text">
            Bitte warten...
            <p>Bitte verlassen Sie diese Seite nicht. <br>
            Sie werden automatisch weitergeleitet,<br> sobald wir die Verarbeitung Ihrer Daten abgeschlossen haben.</p>
        </div>
        <div class="loader_spinner">
            <img src="res/img/loading.gif">
        </div>
    </div>
</div>