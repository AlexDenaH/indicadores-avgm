document.addEventListener('DOMContentLoaded', () => {

    const dependenciaSelect = document.getElementById('id_dependencia');
    const areaSelect        = document.getElementById('id_dep_area');

    // Inyectado desde Blade
    const selectedAreaId = window.selectedDepAreaId ?? null;

    if (!dependenciaSelect || !areaSelect) return;

    /**
     * Cargar áreas según dependencia
     */
    const loadAreas = async (dependenciaId) => {

        areaSelect.innerHTML = '<option value="">Cargando áreas...</option>';
        areaSelect.disabled = true;

        if (!dependenciaId) {
            areaSelect.innerHTML = '<option value="">Seleccione área</option>';
            return;
        }

        try {
            const response = await fetch(`/dependencias/${dependenciaId}/areas`);
            const areas = await response.json();

            areaSelect.innerHTML = '<option value="">Seleccione área</option>';

            areas.forEach(area => {
                const option = document.createElement('option');
                option.value = area.id;
                option.textContent = area.unidad_area; // campo real

                if (selectedAreaId && area.id == selectedAreaId) {
                    option.selected = true;
                }

                areaSelect.appendChild(option);
            });

            areaSelect.disabled = false;

        } catch (error) {
            console.error('Error cargando áreas:', error);
            areaSelect.innerHTML = '<option value="">Error al cargar</option>';
        }
    };

    // Cambio de dependencia
    dependenciaSelect.addEventListener('change', e => {
        loadAreas(e.target.value);
    });

    // Precarga en edición
    if (dependenciaSelect.value) {
        loadAreas(dependenciaSelect.value);
    } else {
        areaSelect.disabled = true;
    }
});
