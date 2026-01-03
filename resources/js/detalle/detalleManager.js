window.detalleManager = function({ niveles, old }) {
    return {
        niveles: niveles ?? [],
        items: old ?? [],  // << importante: si old es undefined, ponemos array vacío
        seleccionado: null,

        get disponibles() {
            return this.niveles.filter(n => !this.items.some(i => i.id == n.id));
        },

        agregar() {
            if (!this.seleccionado) return;
            if (this.items.some(i => i.id == this.seleccionado)) return;

            this.items.push({ id: this.seleccionado, orden: this.items.length + 1 });
            this.seleccionado = null;
        },

        subir(index) {
            if (index === 0) return;
            [this.items[index - 1], this.items[index]] = [this.items[index], this.items[index - 1]];
            this.reordenar();
        },

        bajar(index) {
            if (index === this.items.length - 1) return;
            [this.items[index], this.items[index + 1]] = [this.items[index + 1], this.items[index]];
            this.reordenar();
        },

        eliminar(index) {
            this.items.splice(index, 1);
            this.reordenar();
        },

        reordenar() {
            this.items.forEach((i, idx) => i.orden = idx + 1);
        }
    }
}
