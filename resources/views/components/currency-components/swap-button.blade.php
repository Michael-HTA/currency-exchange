<button onclick="swiftSelectedOptions()" class=" my-1 sm:my-0 material-icons border rounded-full h-10 w-10">
    swap_horiz
</button>

<script>
    function swiftSelectedOptions() {
        const [select1, select2] = [document.getElementById('from'), document.getElementById('to')];
        const [index1, index2] = [select1.selectedIndex, select2.selectedIndex];
        if (index1 >= 0) select2.options[index1].selected = !(select1.options[index1].selected = false);
        if (index2 >= 0) select1.options[index2].selected = !(select2.options[index2].selected = false);
    }
</script>
