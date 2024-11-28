<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Importer\IngredientImporter\IngredientImporter;
use App\Service\IngredientImporterService;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @extends CRUDController<Ingredient>
 */
class IngredientAdminCRUDController extends CRUDController
{
    #[IsGranted(new Expression('is_granted("ROLE_SONATA_ADMIN")'))]
    public function importAction(
        Request $request,
        IngredientImporter $ingredientImporter,
        IngredientImporterService $ingredientImporterService,
    ): Response {
        if ($request->isMethod('POST')) {
            $file = $request->files->get('ingredient_import_file');

            if (!$file instanceof UploadedFile) {
                $this->addFlash('error', 'Aucun fichier détecté.');

                return $this->redirectToRoute('admin_app_ingredient_list');
            }

            try {
                $ingredientImporter->import($ingredientImporterService, $file->getRealPath());

                $insertedCount = $ingredientImporterService->getInsertedIngredientCount();
                $duplicateCount = $ingredientImporterService->getDuplicateIngredientCount();

                $insertedMessage = $insertedCount . ' ingrédient' . ($insertedCount > 1 ? 's ont été insérés.' : ' a été inséré.');
                $this->addFlash('success', $insertedMessage);

                if ($duplicateCount > 0) {
                    $duplicateMessage = $duplicateCount . ' doublon' . ($duplicateCount > 1 ? 's n\'ont pas été pris en compte.' : ' n\'a pas été pris en compte.');
                    $this->addFlash('warning', $duplicateMessage);
                }

                return $this->redirectToRoute('admin_app_ingredient_list');
            } catch (\Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->redirectToRoute('admin_app_ingredient_list');
    }
}
