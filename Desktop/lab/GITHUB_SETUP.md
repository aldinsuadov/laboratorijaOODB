# Vodič za postavljanje Laravel projekta na GitHub

## Korak 1: Priprema projekta

### 1.1 Provjeri .gitignore fajl

Provjeri da li postoji `.gitignore` fajl u root direktorijumu projekta. Laravel obično dolazi sa `.gitignore` fajlom koji već isključuje:
- `.env` fajl (osjetljivi podaci)
- `vendor/` folder (dependencies)
- `node_modules/` folder
- `storage/*.key` fajlovi
- itd.

Ako ne postoji, kreiraj ga sa ovim sadržajem:
```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.idea
/.vscode
```

---

## Korak 2: Kreiranje GitHub repozitorija

### 2.1 Kreiraj novi repozitorij na GitHub-u

1. Idite na [GitHub.com](https://github.com) i prijavite se
2. Kliknite na **"+"** ikonu u gornjem desnom uglu → **"New repository"**
3. Unesite naziv repozitorija (npr. `laboratorija-app`)
4. Izaberite **"Private"** ili **"Public"** (preporučeno: Private za produkciju)
5. **NE** označavajte "Initialize this repository with a README" (već imamo projekat)
6. Kliknite **"Create repository"**

---

## Korak 3: Postavljanje Git-a u projektu

### 3.1 Otvori terminal/command prompt

Otvori terminal u root direktorijumu vašeg Laravel projekta (gdje se nalazi `composer.json`).

### 3.2 Inicijalizuj Git repozitorij (ako već nije)

```bash
git init
```

### 3.3 Provjeri status

```bash
git status
```

Ovo će pokazati koje fajlove Git vidi. Trebali biste vidjeti da `.env`, `vendor/`, `node_modules/` nisu uključeni.

### 3.4 Dodaj sve fajlove

```bash
git add .
```

**Napomena:** Ovo dodaje sve fajlove osim onih navedenih u `.gitignore`.

### 3.5 Napravi prvi commit

```bash
git commit -m "Initial commit: Laravel laboratorija application"
```

---

## Korak 4: Povezivanje sa GitHub repozitorijem

### 4.1 Dodaj remote origin

Nakon što kreirate repozitorij na GitHub-u, dobit ćete URL. Koristite ga ovako:

```bash
git remote add origin https://github.com/VAS_USERNAME/laboratorija-app.git
```

**Zamijenite:**
- `VAS_USERNAME` sa vašim GitHub username-om
- `laboratorija-app` sa nazivom vašeg repozitorija

### 4.2 Provjeri remote

```bash
git remote -v
```

Trebali biste vidjeti:
```
origin  https://github.com/VAS_USERNAME/laboratorija-app.git (fetch)
origin  https://github.com/VAS_USERNAME/laboratorija-app.git (push)
```

---

## Korak 5: Push na GitHub

### 5.1 Push na main branch

```bash
git branch -M main
git push -u origin main
```

Ako koristite stariji Git, možda ćete koristiti `master` umjesto `main`:
```bash
git branch -M master
git push -u origin master
```

### 5.2 Autentifikacija

GitHub će tražiti autentifikaciju. Možete koristiti:
- **Personal Access Token** (preporučeno)
- **GitHub CLI**
- **SSH keys**

---

## Korak 6: Autentifikacija na GitHub

### Opcija A: Personal Access Token (PAT)

1. Idite na GitHub → **Settings** → **Developer settings** → **Personal access tokens** → **Tokens (classic)**
2. Kliknite **"Generate new token"** → **"Generate new token (classic)"**
3. Unesite naziv (npr. "Laravel Project")
4. Izaberite dozvole: **repo** (sve)
5. Kliknite **"Generate token"**
6. **KOPIRAJTE TOKEN ODMAH** (prikazuje se samo jednom!)
7. Kada Git traži password, unesite token umjesto passworda

### Opcija B: GitHub CLI (lakše)

```bash
# Instaliraj GitHub CLI (ako nije instaliran)
# Windows: choco install gh
# Mac: brew install gh
# Linux: sudo apt install gh

# Login
gh auth login

# Zatim pokreni push ponovo
git push -u origin main
```

---

## Korak 7: Provjera

Idite na vaš GitHub repozitorij u browseru. Trebali biste vidjeti sve fajlove vašeg projekta.

---

## Važne napomene

### ⚠️ ŠTA NE TREBA COMMITOVATI:

1. **`.env` fajl** - Sadrži osjetljive podatke (database credentials, API keys)
2. **`vendor/` folder** - Composer dependencies (instaliraju se sa `composer install`)
3. **`node_modules/` folder** - NPM dependencies (instaliraju se sa `npm install`)
4. **`storage/logs/`** - Log fajlovi
5. **`bootstrap/cache/`** - Cache fajlovi

### ✅ ŠTA TREBA COMMITOVATI:

1. Svi source fajlovi (`app/`, `config/`, `database/`, `resources/`, `routes/`)
2. `composer.json` i `composer.lock`
3. `package.json` i `package-lock.json`
4. `.gitignore`
5. `README.md` (ako postoji)

---

## Dodatne korake (opciono)

### Kreiranje README.md

Kreiraj `README.md` fajl sa osnovnim informacijama:

```markdown
# Laboratorija - Laravel Aplikacija

Aplikacija za upravljanje laboratorijskim analizama, terminima i nalazima.

## Instalacija

1. Kloniraj repozitorij
2. Instaliraj dependencies:
   ```bash
   composer install
   npm install
   ```
3. Kopiraj `.env.example` u `.env`
4. Generiši application key:
   ```bash
   php artisan key:generate
   ```
5. Pokreni migracije:
   ```bash
   php artisan migrate
   ```
6. Pokreni server:
   ```bash
   php artisan serve
   ```

## Tehnologije

- Laravel 11
- PHP 8.2+
- MySQL/SQLite
- Tailwind CSS
- Livewire
```

---

## Ažuriranje projekta na GitHub-u

Kada napravite izmjene u projektu:

```bash
# Provjeri status
git status

# Dodaj izmijenjene fajlove
git add .

# Napravi commit
git commit -m "Opis izmjena"

# Push na GitHub
git push
```

---

## Rješavanje problema

### Problem: "fatal: remote origin already exists"

**Rješenje:**
```bash
git remote remove origin
git remote add origin https://github.com/VAS_USERNAME/laboratorija-app.git
```

### Problem: "Permission denied"

**Rješenje:**
- Provjeri da li ste koristili ispravan Personal Access Token
- Provjeri da li imate dozvole za push na repozitorij

### Problem: "Large files" greška

**Rješenje:**
- Provjeri da li pokušavate commitovati velike fajlove (npr. video, velike slike)
- Dodaj ih u `.gitignore` ili koristi Git LFS

---

## Korisne Git komande

```bash
# Provjeri status
git status

# Vidi razlike
git diff

# Vidi commit historiju
git log

# Vrati se na prethodni commit (bez brisanja izmjena)
git reset --soft HEAD~1

# Vrati fajl na prethodnu verziju
git checkout -- filename

# Kreiraj novi branch
git checkout -b feature/nova-funkcionalnost

# Prebaci se na branch
git checkout main

# Merge branch-a
git merge feature/nova-funkcionalnost
```

---

## Sigurnost

**VAŽNO:**
- Nikada ne commit-ujte `.env` fajl
- Koristite `.env.example` sa placeholder vrijednostima
- Provjerite `.gitignore` prije svakog commit-a
- Ako slučajno commit-ujete osjetljive podatke, promijenite ih odmah!

---

## Sljedeći koraci

Nakon što postavite projekat na GitHub:

1. **Kreiraj `.env.example`** sa placeholder vrijednostima
2. **Dodaj README.md** sa uputstvima
3. **Postavi GitHub Actions** za CI/CD (opciono)
4. **Kreiraj Issues** za tracking bugova i feature requesta
5. **Koristi Branches** za razvoj novih funkcionalnosti

---

## Kontakt

Ako imate pitanja ili problema, otvorite Issue na GitHub repozitoriju.
