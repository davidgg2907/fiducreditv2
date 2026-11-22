#!/usr/bin/env node
import { existsSync, readFileSync, readdirSync } from 'node:fs';
import { dirname, join, resolve, extname, relative } from 'node:path';
const frontend=resolve(import.meta.dirname,'..');
const root=resolve(frontend,'..');
const app=join(frontend,'src','app');
const missing=[];
const files=[];
function walk(dir) {for(const d of readdirSync(dir,{withFileTypes:true})) {
  const p=join(dir,d.name);
  if(d.isDirectory())walk(p);else if(extname(p)==='.ts'&&!p.endsWith('.spec.ts'))files.push(p);
}}
function verifyCandidate(label,stem,variants=['','.ts','.js','/index.ts']) {
 if(!variants.some(s=>existsSync(stem+s)))missing.push(label+': '+relative(root,stem));
}
walk(app);files.push(join(frontend,'src','main.ts'));
for(const file of files){
 const body=readFileSync(file,'utf8');
 const withoutComments=body.split('\n').filter(s=>!s.trimStart().startsWith('//')).join('\n');
 const imports=/\b(?:from\s*|import\s*\(\s*)['"]([^'"]+)['"]/g;
 for(const hit of withoutComments.matchAll(imports)){
   const target=hit[1];
   if(target.startsWith('./')||target.startsWith('../'))verifyCandidate(relative(root,file),resolve(dirname(file),target),['.ts','.js','/index.ts']);
   else if(target.startsWith('src/'))verifyCandidate(relative(root,file),resolve(frontend,target),['.ts','.js','/index.ts']);
 }
 const assets=/(?:templateUrl|styleUrls)\s*:\s*(?:\[\s*)?['"]([^'"]+)['"]/g;
 for(const hit of body.matchAll(assets))verifyCandidate(relative(root,file),resolve(dirname(file),hit[1]));
}
for(const p of [
 'backend/artisan','backend/bootstrap/app.php','backend/bootstrap/cache/.gitignore',
 'backend/storage/framework/views/.gitignore','backend/routes/api.php','backend/routes/web.php',
 'backend/resources/views/welcome.blade.php','backend/database/seeders/DatabaseSeeder.php',
 'frontend/src/app/modules/auth/login/login.component.ts',
 'frontend/src/app/appModules/mat.module.ts'
])if(!existsSync(join(root,p)))missing.push('Falta archivo base: '+p);
const mat=readFileSync(join(app,'appModules','mat.module.ts'),'utf8');
if(/from\s+['"](?:ng-apexcharts|ng2-charts)['"]/.test(mat))missing.push('MatModule importa librerias eliminadas.');
if(missing.length){console.error('ARQUETIPO INVALIDO');for(const err of missing)console.error(' - '+err);process.exitCode=1;}
else console.log('Estructura valida: '+files.length+' archivos TS revisados. Autenticación y Laravel presentes.');
