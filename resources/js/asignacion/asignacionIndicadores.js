export function formEditar() {
    return {
        ejercicio: null,
        programa: null,
        programas: [],
        indicadores: [],
        seleccionados: [],

        init() {
                const data = this.$el.dataset.asignacion;
                if (!data) return;

                const asignacion = JSON.parse(data);

                this.ejercicio = asignacion.id_ejercicio;
                this.programa  = asignacion.id_programa;

                // indicadores asignados (convertidos a number)
                this.seleccionados = Array.isArray(asignacion.indicadores)
                    ? asignacion.indicadores.map(i => Number(i))
                    : [];

                // cargar programas y luego indicadores
                this.cargarProgramas(true);

              //  console.log('Seleccionados:', this.seleccionados);
            },

        cargarProgramas(init = false) {
            if (!this.ejercicio) return;

            fetch(`/api/programas/${this.ejercicio}`)
                .then(r => r.json())
                .then(data => {
                    this.programas = data;

                    // 👇 SOLO en EDIT
                    if (init) {
                        this.$nextTick(() => {
                            this.cargarIndicadores();
                        });
                    }
                });
        },

        cargarIndicadores() {
            if (!this.programa) return;

            fetch(`/api/indicadores/${this.programa}`)
                .then(r => r.json())
                .then(data => {
                    this.indicadores = data;
                });

        }
    }
}
