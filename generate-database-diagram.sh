#!/bin/bash

# Generate Database Design Diagrams
# This script opens all database design diagrams in VS Code

echo "🗄️  Opening Database Design Diagrams..."

# ERD Diagram
if [ -f "dokumentasi/database-design/erd-diagram.mmd" ]; then
    echo "📊 Opening ERD Diagram..."
    code dokumentasi/database-design/erd-diagram.mmd
else
    echo "❌ ERD Diagram not found!"
fi

# Database Relationship Overview
if [ -f "dokumentasi/database-design/database-relationship-overview.mmd" ]; then
    echo "🔗 Opening Database Relationship Overview..."
    code dokumentasi/database-design/database-relationship-overview.mmd
else
    echo "❌ Database Relationship Overview not found!"
fi

# README
if [ -f "dokumentasi/database-design/README.md" ]; then
    echo "📖 Opening Database Design Documentation..."
    code dokumentasi/database-design/README.md
else
    echo "❌ README not found!"
fi

echo ""
echo "✅ Done! All database design files opened."
echo ""
echo "💡 Tips:"
echo "   - Install 'Markdown Preview Mermaid Support' extension untuk preview diagram"
echo "   - Atau copy paste ke https://mermaid.live/ untuk preview online"
echo "   - Tekan Ctrl+Shift+V di VS Code untuk preview Markdown"
echo ""
