#!/bin/bash
# Script untuk convert Mermaid diagram ke PNG

echo "🔄 Converting All Diagrams to PNG..."
echo ""
echo "=================================================="
echo "           USE CASE DIAGRAMS"
echo "=================================================="

# Use Case Diagrams
UC_DIR="dokumentasi/use-case"

echo ""
echo "1. Converting use-case-diagram.mmd (All Roles - Horizontal)..."
mmdc -i $UC_DIR/use-case-diagram.mmd -o $UC_DIR/use-case-diagram.png -w 3000 -H 2000 -b white
echo "   ✓ use-case-diagram.png created!"

echo ""
echo "2. Converting use-case-vertical.mmd (All Roles - Vertical)..."
mmdc -i $UC_DIR/use-case-vertical.mmd -o $UC_DIR/use-case-vertical.png -w 1800 -H 4500 -b white
echo "   ✓ use-case-vertical.png created!"

echo ""
echo "3. Converting usecase-admin.mmd (Admin Only)..."
mmdc -i $UC_DIR/usecase-admin.mmd -o $UC_DIR/usecase-admin.png -w 2000 -H 3000 -b white
echo "   ✓ usecase-admin.png created!"

echo ""
echo "4. Converting usecase-nurse.mmd (Nurse Only)..."
mmdc -i $UC_DIR/usecase-nurse.mmd -o $UC_DIR/usecase-nurse.png -w 2000 -H 2500 -b white
echo "   ✓ usecase-nurse.png created!"

echo ""
echo "5. Converting usecase-doctor.mmd (Doctor Only)..."
mmdc -i $UC_DIR/usecase-doctor.mmd -o $UC_DIR/usecase-doctor.png -w 2000 -H 2500 -b white
echo "   ✓ usecase-doctor.png created!"

echo ""
echo "6. Converting usecase-pharmacist.mmd (Pharmacist Only)..."
mmdc -i $UC_DIR/usecase-pharmacist.mmd -o $UC_DIR/usecase-pharmacist.png -w 2000 -H 3000 -b white
echo "   ✓ usecase-pharmacist.png created!"

echo ""
echo "=================================================="
echo "         ACTIVITY DIAGRAMS"
echo "=================================================="

# Activity Diagrams
ACT_DIR="dokumentasi/activity-diagram"

echo ""
echo "7. Converting activity-diagram-registrasi.mmd..."
mmdc -i $ACT_DIR/activity-diagram-registrasi.mmd -o $ACT_DIR/activity-diagram-registrasi.png -w 2000 -H 2500 -b white
echo "   ✓ activity-diagram-registrasi.png created!"

echo ""
echo "8. Converting activity-diagram-pemeriksaan-awal.mmd..."
mmdc -i $ACT_DIR/activity-diagram-pemeriksaan-awal.mmd -o $ACT_DIR/activity-diagram-pemeriksaan-awal.png -w 2000 -H 3500 -b white
echo "   ✓ activity-diagram-pemeriksaan-awal.png created!"

echo ""
echo "9. Converting activity-diagram-pemeriksaan-dokter.mmd..."
mmdc -i $ACT_DIR/activity-diagram-pemeriksaan-dokter.mmd -o $ACT_DIR/activity-diagram-pemeriksaan-dokter.png -w 2000 -H 4000 -b white
echo "   ✓ activity-diagram-pemeriksaan-dokter.png created!"

echo ""
echo "10. Converting activity-diagram-proses-resep.mmd..."
mmdc -i $ACT_DIR/activity-diagram-proses-resep.mmd -o $ACT_DIR/activity-diagram-proses-resep.png -w 2000 -H 3500 -b white
echo "   ✓ activity-diagram-proses-resep.png created!"

echo ""
echo "11. Converting activity-diagram-manajemen-stok.mmd..."
mmdc -i $ACT_DIR/activity-diagram-manajemen-stok.mmd -o $ACT_DIR/activity-diagram-manajemen-stok.png -w 2000 -H 4500 -b white
echo "   ✓ activity-diagram-manajemen-stok.png created!"

echo ""
echo "=================================================="
echo "✅ All diagrams created successfully!"
echo "=================================================="
echo ""
echo "📁 Files created in dokumentasi/:"
echo ""
echo "   📂 use-case/"
echo "      - use-case-diagram.png (3000x2000) - All roles horizontal"
echo "      - use-case-vertical.png (1800x4500) - All roles vertical"
echo "      - usecase-admin.png (2000x3000)"
echo "      - usecase-nurse.png (2000x2500)"
echo "      - usecase-doctor.png (2000x2500)"
echo "      - usecase-pharmacist.png (2000x3000)"
echo ""
echo "   📂 activity-diagram/"
echo "      - activity-diagram-registrasi.png (2000x2500)"
echo "      - activity-diagram-pemeriksaan-awal.png (2000x3500)"
echo "      - activity-diagram-pemeriksaan-dokter.png (2000x4000)"
echo "      - activity-diagram-proses-resep.png (2000x3500)"
echo "      - activity-diagram-manajemen-stok.png (2000x4500)"
echo ""
echo "💡 Tips:"
echo "   - Semua diagram sudah dalam folder dokumentasi/"
echo "   - Format vertical cocok untuk presentasi/laporan"
echo "   - Background putih, siap untuk di-print"
echo "   - Untuk export ke SVG: mmdc -i [file].mmd -o [file].svg"
