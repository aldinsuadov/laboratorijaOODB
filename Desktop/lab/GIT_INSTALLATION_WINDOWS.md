# Instalacija Git-a na Windows

## Problem
```
git : The term 'git' is not recognized as the name of a cmdlet, function, script file, or operable program.
```

Ovo znači da Git nije instaliran na vašem sistemu.

---

## Rješenje: Instaliraj Git

### Metoda 1: Preuzimanje sa zvaničnog sajta (Preporučeno)

1. **Idite na:** https://git-scm.com/download/win
2. **Preuzmite** najnoviju verziju Git-a za Windows
3. **Pokrenite** instalaciju (Git-x.x.x-64-bit.exe)
4. **Tijekom instalacije:**
   - Kliknite "Next" kroz sve korake
   - **VAŽNO:** Na "Adjusting your PATH environment" izaberite:
     - ✅ **"Git from the command line and also from 3rd-party software"** (preporučeno)
   - Na "Choosing the default editor" možete izabrati "Nano" ili "Notepad" (jednostavniji)
   - Kliknite "Next" kroz ostale korake
   - Kliknite "Install"

5. **Nakon instalacije:**
   - Zatvorite sve PowerShell/Command Prompt prozore
   - Otvorite **NOVI** PowerShell prozor
   - Provjerite instalaciju:
     ```powershell
     git --version
     ```
   - Trebali biste vidjeti nešto kao: `git version 2.xx.x.windows.x`

---

### Metoda 2: Korištenje Chocolatey (Ako imate instaliran)

Ako imate Chocolatey package manager instaliran:

```powershell
choco install git
```

---

### Metoda 3: Korištenje Winget (Windows 11/10)

```powershell
winget install --id Git.Git -e --source winget
```

---

## Provjera instalacije

Nakon instalacije, otvorite **NOVI** PowerShell prozor i pokrenite:

```powershell
git --version
```

Ako vidite verziju (npr. `git version 2.42.0.windows.2`), Git je uspješno instaliran! ✅

---

## Konfiguracija Git-a (Prvi put)

Nakon instalacije, konfigurišite Git sa vašim imenom i email-om:

```powershell
git config --global user.name "Vaše Ime"
git config --global user.email "vas@email.com"
```

**Primjer:**
```powershell
git config --global user.name "Hodzic"
git config --global user.email "hodzic@example.com"
```

Provjerite konfiguraciju:
```powershell
git config --list
```

---

## Sada možete koristiti Git komande

Nakon instalacije, možete nastaviti sa postavljanjem projekta na GitHub:

```powershell
# Idite u direktorij projekta
cd C:\Users\Hodzic\Desktop\lab

# Provjeri status
git status

# Ako nije inicijalizovan, inicijalizuj
git init

# Dodaj fajlove
git add .

# Napravi commit
git commit -m "Initial commit"
```

---

## Troubleshooting

### Problem: "git is not recognized" i nakon instalacije

**Rješenje:**
1. Zatvorite sve terminal prozore
2. Otvorite **NOVI** PowerShell/Command Prompt prozor
3. Git se dodaje u PATH, ali postojeći prozori ne vide promjene

### Problem: Git instaliran ali ne radi u PowerShell

**Rješenje:**
1. Provjerite PATH varijablu:
   ```powershell
   $env:Path
   ```
2. Trebali biste vidjeti putanju do Git-a (obično `C:\Program Files\Git\cmd`)
3. Ako nije tu, dodajte ga ručno:
   - Windows Settings → System → About → Advanced system settings
   - Environment Variables → System variables → Path → Edit
   - Dodajte: `C:\Program Files\Git\cmd`

### Problem: Trebam restartovati računar?

**Rješenje:**
- Obično nije potrebno, samo zatvorite i otvorite novi terminal prozor
- Ako i dalje ne radi, restartujte računar

---

## Alternativa: GitHub Desktop

Ako ne želite koristiti komandnu liniju, možete koristiti **GitHub Desktop** (GUI aplikacija):

1. Preuzmite sa: https://desktop.github.com/
2. Instalirajte
3. Login sa GitHub nalogom
4. Možete dodati projekat kroz GUI

---

## Sljedeći koraci

Nakon što instalirate Git:

1. Otvorite novi PowerShell prozor
2. Idite u direktorij projekta: `cd C:\Users\Hodzic\Desktop\lab`
3. Provjerite da Git radi: `git --version`
4. Nastavite sa koracima iz `GITHUB_SETUP.md`

---

## Kontakt

Ako i dalje imate problema, provjerite:
- Da li ste zatvorili i otvorili novi terminal prozor
- Da li je Git instaliran u `C:\Program Files\Git\`
- Da li je PATH varijabla ispravno postavljena
