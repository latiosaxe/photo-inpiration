<div class="color-container">
    <div class="color_picker_dialog" draggable="false">
        <div class="hue_bar">
            <div class="hue_picker"></div>
        </div>
        <div class="sat_rect" draggable="false">
            <div class="white"></div>
            <div class="black"></div>
            <div class="sat_picker"></div>
        </div>
        <div class="bottom">
            <div class="color_preview"></div>
            <input type="text" onkeyup="changeHex(this.value)" value="#C8D594" />
            <button data-color="/color/255-0-0" id="searchByColor" class="btn" disabled="disabled">Buscar</button>
        </div>
    </div>
</div>