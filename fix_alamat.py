file_path = r'd:\ROSYID\MANAJEMEN_DATA_SANTRI\resources\views\wali\santri\edit.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

in_alamat_santri = False
for i, line in enumerate(lines):
    if 'Alamat Santri & Transportasi' in line and 'section-title' in line:
        in_alamat_santri = True
    
    if 'ACTION BUTTONS' in line:
        in_alamat_santri = False
        
    if in_alamat_santri and '<label' in line and '<span class="req">*</span>' in line:
        lines[i] = line.replace('<span class="req">*</span>', '<span class="opt">(diisi admin)</span>')

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(lines)
