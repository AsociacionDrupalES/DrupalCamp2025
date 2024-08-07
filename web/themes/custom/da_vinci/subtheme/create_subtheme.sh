#!/bin/bash
# Script to quickly create sub-theme.

echo '

                ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
                ░░░░░░░░░░▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄░░░░░░░░░
                ░░░░░░░░▄▀░░░░░░░░░░░░▄░░░░░░░▀▄░░░░░░░
                ░░░░░░░░█░░▄░░░░▄░░░░░░░░░░░░░░█░░░░░░░
                ░░░░░░░░█░░░░░░░░░░░░▄█▄▄░░▄░░░█░▄▄▄░░░
                ░▄▄▄▄▄░░█░░░░░░▀░░░░▀█░░▀▄░░░░░█▀▀░██░░
                ░██▄▀██▄█░░░▄░░░░░░░██░░░░▀▀▀▀▀░░░░██░░
                ░░▀██▄▀██░░░░░░░░▀░██▀░░░░░░░░░░░░░▀██░
                ░░░░▀████░▀░░░░▄░░░██░░░▄█░░░░▄░▄█░░██░
                ░░░░░░░▀█░░░░▄░░░░░██░░░░▄░░░▄░░▄░░░██░
                ░░░░░░░▄█▄░░░░░░░░░░░▀▄░░▀▀▀▀▀▀▀▀░░▄▀░░
                ░░░░░░█▀▀█████████▀▀▀▀████████████▀░░░░
                ░░░░░░████▀░░███▀░░░░░░▀███░░▀██▀░░░░░░
                ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░

+------------------------------------------------------------------------+
| With this script you could quickly create "Da Vinci" sub-theme         |
| In order to use this:                                                  |
| - da_vinci theme (this folder) should be in the contrib folder         |
+------------------------------------------------------------------------+
'
echo 'The machine name of your custom theme? [e.g. ginebra]'
read CUSTOM_DA_VINCI

echo 'Your theme name ? [e.g. Ginebra Theme]'
read CUSTOM_DA_VINCI_NAME

if [[ ! -e ../../custom ]]; then
    mkdir ../../custom
fi
cd ../../custom
cp -r ../contrib/da_vinci $CUSTOM_DA_VINCI
cd $CUSTOM_DA_VINCI
for file in *da_vinci.*; do mv $file ${file//da_vinci/$CUSTOM_DA_VINCI}; done
for file in config/*da_vinci.*; do mv $file ${file//da_vinci/$CUSTOM_DA_VINCI}; done
for file in config/*/block.block.da_vinci_*; do mv $file ${file//da_vinci/$CUSTOM_DA_VINCI}; done
for file in config/*/*da_vinci.*; do mv $file ${file//da_vinci/$CUSTOM_DA_VINCI}; done
cd subtheme
for file in *subtheme.*; do mv $file ${file//subtheme/$CUSTOM_DA_VINCI}; done
cd ../
# Remove create_subtheme.sh file, we do not need it in customized subtheme.
rm composer.json
rm -rf .git js templates
rm LICENSE.txt
rm $CUSTOM_DA_VINCI.info.yml
grep -Rl da_vinci .|xargs sed -i -e "s/da_vinci/$CUSTOM_DA_VINCI/"
mv subtheme/* .
mv $CUSTOM_DA_VINCI.info{,.yml}
sed -i -e "s/Da Vinci/$CUSTOM_DA_VINCI_NAME/" $CUSTOM_DA_VINCI.info.yml
sed -i -e "s/classy/da_vinci/" $CUSTOM_DA_VINCI.info.yml
grep -Rl subtheme .|xargs sed -i -e "s/subtheme/$CUSTOM_DA_VINCI/"
rm -rf subtheme
rm create_$CUSTOM_DA_VINCI.sh
echo '
██╗░░░░░███████╗████████╗██╗░██████╗  ██████╗░░█████╗░░█████╗░██╗░░██╗
██║░░░░░██╔════╝╚══██╔══╝╚█║██╔════╝  ██╔══██╗██╔══██╗██╔══██╗██║░██╔╝
██║░░░░░█████╗░░░░░██║░░░░╚╝╚█████╗░  ██████╔╝██║░░██║██║░░╚═╝█████═╝░
██║░░░░░██╔══╝░░░░░██║░░░░░░░╚═══██╗  ██╔══██╗██║░░██║██║░░██╗██╔═██╗░
███████╗███████╗░░░██║░░░░░░██████╔╝  ██║░░██║╚█████╔╝╚█████╔╝██║░╚██╗
╚══════╝╚══════╝░░░╚═╝░░░░░░╚═════╝░  ╚═╝░░╚═╝░╚════╝░░╚════╝░╚═╝░░╚═╝
'
echo "# Check the themes/custom folder for your new sub-theme."
